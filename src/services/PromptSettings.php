<?php

namespace stubr\services;

use Craft;
use craft\base\Component;
use craft\db\Query;
use craft\helpers\Db;
use craft\helpers\StringHelper;
use craft\helpers\ProjectConfig as ProjectConfigHelper;

class PromptSettings extends Component
{
    public const TABLE = '{{%craft_loki_prompt_settings}}';

    private const PROMPTS = 'prompts';
    private const FIELD_ASSIGNMENTS = 'fieldAssignments';
    private const FIELD_ORDER = 'fieldOrder';
    // Stored as its own row (JSON true/false) so admins can change it on every environment
    private const ADMIN_ONLY = 'promptEditingAdminOnly';

    // Added in a later release; a migration appends it to installs that already have prompts saved
    public const QUOTES_PROMPT_UID = '128ba0d7-d3ba-47b3-9c48-9ef1ac51c3a5';

    private ?array $_all = null;

    public static function defaultPrompts(): array
    {
        return [
            [
                'uid' => '3bb64867-266b-439d-a36c-a2d54da75fa4',
                'text' => 'DE',
                'label' => 'Translate to DE',
                'provider' => 'deepl',
                'effort' => 'medium',
                'createDraft' => '',
                'allPlainText' => '1',
                'allCKEditor' => '1',
            ],
            [
                'uid' => 'd9f85ad2-9677-4958-9583-71c973ad0d79',
                'text' => 'Translate to {{ siteLang }}',
                'label' => 'Translate to current language',
                'provider' => 'openai',
                'effort' => 'medium',
                'createDraft' => '',
                'allPlainText' => '1',
                'allCKEditor' => '1',
            ],
            [
                'uid' => 'e4bc07b5-4442-4859-afe7-884b65662e0c',
                'text' => 'Correct syntax, spelling, and grammar',
                'label' => 'Correct',
                'provider' => 'openai',
                'effort' => 'medium',
                'createDraft' => '',
                'allPlainText' => '1',
                'allCKEditor' => '1',
            ],
            [
                'uid' => '807c5365-8771-4dec-b92b-53f080ebab05',
                'text' => 'Shorten text to 3/4 length',
                'label' => 'Shorten',
                'provider' => 'claude',
                'effort' => 'medium',
                'createDraft' => '',
                'allPlainText' => '1',
                'allCKEditor' => '1',
            ],
            [
                'uid' => self::QUOTES_PROMPT_UID,
                'text' => <<<TXT
                Correct all quotation marks in the text. The text is written in {{ siteLang }}; use that language's style:
                - German and Italian: «double» and ‹single›, no spaces inside.
                - French: « double » and ‹ single ›, with a non-breaking space inside the quotation marks.
                - English: “double” and ‘single’.
                - Any other language: its standard typographic quotation marks.
                Only change quotation marks. Do not change apostrophes (e.g. it's, l'amour, geht's), HTML tags or HTML attribute values, or anything else in the text.
                TXT,
                'label' => 'Correct quotes',
                'provider' => 'openai',
                'effort' => 'medium',
                'createDraft' => '',
                'allPlainText' => '1',
                'allCKEditor' => '1',
            ],
        ];
    }

    public static function quotesPrompt(): array
    {
        $prompts = array_column(self::defaultPrompts(), null, 'uid');

        return $prompts[self::QUOTES_PROMPT_UID];
    }

    public function getAll(): array
    {
        if ($this->_all !== null) {
            return $this->_all;
        }

        $stored = $this->storedValues();
        $legacy = $this->legacySettings();

        $this->_all = [
            self::PROMPTS => $stored[self::PROMPTS] ?? $this->arrayValue($legacy[self::PROMPTS] ?? null, self::defaultPrompts()),
            self::FIELD_ASSIGNMENTS => $stored[self::FIELD_ASSIGNMENTS] ?? $this->arrayValue($legacy[self::FIELD_ASSIGNMENTS] ?? null),
            self::FIELD_ORDER => $stored[self::FIELD_ORDER] ?? $this->arrayValue($legacy[self::FIELD_ORDER] ?? null),
            self::ADMIN_ONLY => ($stored[self::ADMIN_ONLY] ?? false) === true,
        ];

        return $this->_all;
    }

    public function isPromptEditingAdminOnly(): bool
    {
        return $this->getAll()[self::ADMIN_ONLY];
    }

    public function savePromptEditingAdminOnly(bool $value): void
    {
        if (!$this->tableExists()) {
            throw new \RuntimeException('The Craft Loki prompt settings table does not exist. Run plugin migrations first.');
        }

        $this->saveValue(self::ADMIN_ONLY, $value);
        $this->_all = null;
    }

    // Single source of truth for who may edit prompts (used by the page and the save action)
    public function canEditPrompts(): bool
    {
        $user = Craft::$app->getUser()->getIdentity();
        if (!$user) {
            return false;
        }

        // Switch off: any logged-in user may edit
        return !$this->isPromptEditingAdminOnly() || $user->admin;
    }

    public function getPrompts(): array
    {
        return $this->getAll()[self::PROMPTS];
    }

    // Returns the prompt with label and text in the current user's CP language:
    // 1) default prompts: label from the static translation files (text stays as is)
    // 2) custom prompts: label and text from the DeepL translations saved with the prompt
    // 3) otherwise: as entered
    public function localize(array $prompt): array
    {
        $label = $prompt['label'] ?? '';
        $staticLabel = Craft::t('craft-loki', $label);

        if ($staticLabel !== $label) {
            $prompt['label'] = $staticLabel;
        } else {
            $translation = $prompt['translations'][substr(Craft::$app->language, 0, 2)] ?? [];
            $prompt['label'] = $translation['label'] ?? $label;
            $prompt['text'] = $translation['text'] ?? ($prompt['text'] ?? '');
        }

        unset($prompt['translations']);

        return $prompt;
    }

    public function getFieldAssignments(): array
    {
        return $this->getAll()[self::FIELD_ASSIGNMENTS];
    }

    public function saveAll(array $values): void
    {
        if (!$this->tableExists()) {
            throw new \RuntimeException('The Craft Loki prompt settings table does not exist. Run plugin migrations first.');
        }

        $this->saveValue(self::PROMPTS, $this->arrayValue($values[self::PROMPTS] ?? null));
        $this->saveValue(self::FIELD_ASSIGNMENTS, $this->arrayValue($values[self::FIELD_ASSIGNMENTS] ?? null));
        $this->saveValue(self::FIELD_ORDER, $this->arrayValue($values[self::FIELD_ORDER] ?? null));
        $this->_all = null;
    }

    private function storedValues(): array
    {
        if (!$this->tableExists()) {
            return [];
        }

        $rows = (new Query())
            ->select(['name', 'value'])
            ->from(self::TABLE)
            ->all();

        $values = [];
        foreach ($rows as $row) {
            $decoded = json_decode((string)$row['value'], true);
            if (is_array($decoded) || is_bool($decoded)) {
                $values[$row['name']] = $decoded;
            }
        }

        return $values;
    }

    private function saveValue(string $name, array|bool $value): void
    {
        $db = Craft::$app->getDb();
        $now = Db::prepareDateForDb(new \DateTime());
        $encoded = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $exists = (new Query())
            ->from(self::TABLE)
            ->where(['name' => $name])
            ->exists();

        if ($exists) {
            $db->createCommand()
                ->update(self::TABLE, [
                    'value' => $encoded,
                    'dateUpdated' => $now,
                ], ['name' => $name])
                ->execute();

            return;
        }

        $db->createCommand()
            ->insert(self::TABLE, [
                'name' => $name,
                'value' => $encoded,
                'dateCreated' => $now,
                'dateUpdated' => $now,
                'uid' => StringHelper::UUID(),
            ])
            ->execute();
    }

    private function tableExists(): bool
    {
        return Craft::$app->getDb()->getTableSchema(self::TABLE, true) !== null;
    }

    private function legacySettings(): array
    {
        $settings = Craft::$app->getProjectConfig()->get('plugins.craft-loki.settings') ?? [];

        if (!is_array($settings)) {
            return [];
        }

        return ProjectConfigHelper::unpackAssociativeArrays($settings);
    }

    private function arrayValue(mixed $value, array $default = []): array
    {
        return is_array($value) ? $value : $default;
    }
}
