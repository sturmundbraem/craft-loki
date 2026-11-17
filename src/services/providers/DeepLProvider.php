<?php

namespace stubr\services\providers;

use stubr\services\providers\LlmProviderInterface;
use GuzzleHttp\Client;
use craft\helpers\App;
use stubr\Plugin;

class DeepLProvider implements LlmProviderInterface
{
    // DeepL Free keys end in ":fx" and use a different host than Pro keys
    public static function apiUrl(string $apiKey): string
    {
        return str_ends_with($apiKey, ':fx')
            ? 'https://api-free.deepl.com/v2/translate'
            : 'https://api.deepl.com/v2/translate';
    }

    // DeepL is a translation API, not an LLM — it has no effort concept, so
    // $options is accepted (the interface requires it) and ignored.
    public function generateText($prompt, $context, $fieldHandle, string $systemPrompt, array $options = []):string {
        $client = new Client();

        $apiKey = App::parseEnv(Plugin::$plugin->getSettings()->deeplApiKey);
        if (!$apiKey) {
            throw new \Exception('DeepL API key not configured');
        }

        $targetLang = $prompt;

        preg_match('/' . $fieldHandle . ': (.+)/', $context, $matches);
        $textToTranslate = $matches[1] ?? '';

        try {
            $response = $client->post(self::apiUrl($apiKey), [
                'headers' => [
                    'Authorization' => 'DeepL-Auth-Key ' . $apiKey,
                ],
                'form_params' => [
                    'text' => $textToTranslate,
                    'target_lang' => $targetLang,
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorBody = $e->getResponse()->getBody()->getContents();
            throw new \Exception('DeepL API error: ' . $errorBody);
        }

        $body = json_decode($response->getBody(), true);
        return $body['translations'][0]['text'];        

    }
}
