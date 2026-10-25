<?php

namespace stubr\migrations;

use craft\db\Migration;
use stubr\services\PromptSettings;

// Runs on a fresh install (and safeDown on uninstall).
// Craft marks all other migrations as applied on install without running them,
// so everything a fresh install needs must be created here.
class Install extends Migration
{
    public function safeUp(): bool
    {
        if ($this->db->getTableSchema(PromptSettings::TABLE, true) === null) {
            $this->createTable(PromptSettings::TABLE, [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'value' => $this->text(),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid(),
            ]);
            $this->createIndex(null, PromptSettings::TABLE, ['name'], true);
        }

        // No seeding needed: without stored rows, PromptSettings falls back to the default prompts

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTableIfExists(PromptSettings::TABLE);

        return true;
    }
}
