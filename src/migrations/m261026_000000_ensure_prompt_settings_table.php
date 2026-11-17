<?php

namespace stubr\migrations;

use craft\db\Migration;

// Installs made before Install.php existed never ran m260618_000000_create_prompt_settings_table
// (Craft only marks migrations as applied on install), so the table may be missing. Create it if so.
class m261026_000000_ensure_prompt_settings_table extends Migration
{
    public function safeUp(): bool
    {
        return (new Install(['db' => $this->db]))->safeUp();
    }

    public function safeDown(): bool
    {
        echo "m261026_000000_ensure_prompt_settings_table cannot be reverted.\n";
        return false;
    }
}
