<?php

namespace stubr\services;

use Craft;
use craft\helpers\App;
use stubr\Plugin;
use stubr\services\providers\DeepLProvider;

// Translates custom prompts (label + text) with DeepL when the Prompts page is saved.
// Default prompts are translated by the static files in src/translations and are skipped here.
class PromptTranslator
{
    // CP language (first two letters) => DeepL target_lang
    public const TARGETS = ['de' => 'DE', 'fr' => 'FR', 'it' => 'IT', 'en' => 'EN-GB'];

    public static function hasStaticTranslation(string $label): bool
    {
        return Craft::t('craft-loki', $label, [], 'de') !== $label;
    }

    /**
     * Adds a 'translations' key to every custom prompt:
     * ['source' => [label, text], 'de' => [label, text], 'fr' => ..., ...]
     * Prompts whose label and text are unchanged reuse their existing translations (no DeepL call).
     *
     * Returns an error message if DeepL could not be used. The prompts are still usable then,
     * changed prompts just have no translations and are shown as entered.
     */
    public function translate(array &$prompts, array $existingPromptsByUid): ?string
    {
        // prompt key => ['label' => ..., 'text' => ...|null]
        $pending = [];

        foreach ($prompts as $key => $prompt) {
            unset($prompts[$key]['translations']);

            $label = trim((string)($prompt['label'] ?? ''));
            if ($label === '' || self::hasStaticTranslation($label)) {
                continue;
            }

            // DeepL prompts hold a target_lang code (e.g. "DE"), not an instruction
            $text = ($prompt['provider'] ?? '') === 'deepl' ? null : trim((string)($prompt['text'] ?? ''));
            $source = ['label' => $label, 'text' => $text ?: null];

            $existing = $existingPromptsByUid[$prompt['uid'] ?? '']['translations'] ?? null;
            if (is_array($existing) && ($existing['source'] ?? null) === $source) {
                $prompts[$key]['translations'] = $existing;
                continue;
            }

            $pending[$key] = $source;
        }

        if (!$pending) {
            return null;
        }

        $apiKey = App::parseEnv(Plugin::$plugin->getSettings()->deeplApiKey);
        if (!$apiKey) {
            return Craft::t('craft-loki', 'Prompts saved, but custom prompts were not translated: no DeepL API key configured.');
        }

        // Flatten all pending labels and texts so each language needs only one request
        $texts = [];
        $targets = [];   // same index as $texts => [prompt key, 'label'|'text']
        foreach ($pending as $key => $source) {
            foreach (['label', 'text'] as $part) {
                if ($source[$part] !== null) {
                    $texts[] = $source[$part];
                    $targets[] = [$key, $part];
                }
            }
        }

        try {
            $results = [];
            foreach (self::TARGETS as $lang => $targetLang) {
                $results[$lang] = $this->request($apiKey, $texts, $targetLang);
            }
        } catch (\Throwable $e) {
            Craft::warning('DeepL prompt translation failed: ' . $e->getMessage(), 'craft-loki');
            return Craft::t('craft-loki', 'Prompts saved, but custom prompts could not be translated: {error}', [
                'error' => $e->getMessage(),
            ]);
        }

        foreach ($pending as $key => $source) {
            $prompts[$key]['translations'] = ['source' => $source];
        }
        foreach ($results as $lang => $translations) {
            foreach ($translations as $i => $translation) {
                [$key, $part] = $targets[$i];
                // Keep the original wording for the language it was written in
                $isSourceLanguage = strtolower(substr($translation['detectedLanguage'], 0, 2)) === $lang;
                $prompts[$key]['translations'][$lang][$part] = $isSourceLanguage ? $texts[$i] : $translation['text'];
            }
        }

        return null;
    }

    private function request(string $apiKey, array $texts, string $targetLang): array
    {
        // Twig tags ({{ siteLang }}, {% if %}) are wrapped in <x>, which DeepL is told to leave untouched.
        // XML mode requires escaping &, < and > first; they're decoded again below.
        $xmlTexts = array_map(
            fn(string $text) => preg_replace('/\{\{.*?\}\}|\{%.*?%\}/s', '<x>$0</x>', htmlspecialchars($text, ENT_NOQUOTES)),
            $texts
        );

        $response = Craft::createGuzzleClient(['timeout' => 15])->post(DeepLProvider::apiUrl($apiKey), [
            'headers' => ['Authorization' => 'DeepL-Auth-Key ' . $apiKey],
            'json' => [
                'text' => $xmlTexts,
                'target_lang' => $targetLang,
                'tag_handling' => 'xml',
                'ignore_tags' => ['x'],
                'preserve_formatting' => true,
            ],
        ]);

        $translations = json_decode((string)$response->getBody(), true)['translations'] ?? [];
        if (count($translations) !== count($texts)) {
            throw new \RuntimeException('Unexpected DeepL response.');
        }

        return array_map(fn(array $translation) => [
            'text' => html_entity_decode(str_replace(['<x>', '</x>'], '', $translation['text']), ENT_QUOTES | ENT_XML1),
            'detectedLanguage' => $translation['detected_source_language'] ?? '',
        ], $translations);
    }
}
