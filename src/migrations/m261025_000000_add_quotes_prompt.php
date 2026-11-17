<?php

namespace stubr\migrations;

use craft\db\Migration;
use craft\db\Query;
use craft\helpers\Db;
use stubr\services\PromptSettings;

// Appends the new "Correct quotes" default prompt to installs that already have prompts saved.
// Installs without a saved prompts row use PromptSettings::defaultPrompts(), which already includes it.
class m261025_000000_add_quotes_prompt extends Migration
{
    public function safeUp(): bool
    {
        if ($this->db->getTableSchema(PromptSettings::TABLE, true) === null) {
            return true;
        }

        $row = (new Query())
            ->select(['value'])
            ->from(PromptSettings::TABLE)
            ->where(['name' => 'prompts'])
            ->one();

        $prompts = $row ? json_decode((string)$row['value'], true) : null;
        if (!is_array($prompts)) {
            return true;
        }

        if (in_array(PromptSettings::QUOTES_PROMPT_UID, array_column($prompts, 'uid'), true)) {
            return true;
        }

        $prompts[] = PromptSettings::quotesPrompt();

        $this->update(PromptSettings::TABLE, [
            'value' => json_encode($prompts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'dateUpdated' => Db::prepareDateForDb(new \DateTime()),
        ], ['name' => 'prompts']);

        return true;
    }

    public function safeDown(): bool
    {
        echo "m261025_000000_add_quotes_prompt cannot be reverted.\n";
        return false;
    }
}
