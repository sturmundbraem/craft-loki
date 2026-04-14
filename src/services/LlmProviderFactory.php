<?php

namespace stubr\services;

use stubr\services\providers\OpenAiProvider;
use stubr\services\providers\LlmProviderInterface;
use stubr\services\providers\ClaudeProvider;
use stubr\services\providers\DeepLProvider;


class LlmProviderFactory
{
    private static ?self $instance = null;

    private function __construct() {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getProvider(string $provider) {
        if ($provider === 'openai') {
            // Create the OpenAI provider and call its generateText method
            $openAiProvider = new OpenAiProvider();
            return $openAiProvider;
        }
        if ($provider === 'claude') {
            return new ClaudeProvider();
        }
        if ($provider === 'deepl') {
            return new DeepLProvider();
        }

        else {
            // If the provider is not recognized, throw an error
            throw new \Exception("Unsupported AI provider: " . $provider);
        }
    }
}

