<?php

namespace stubr\controllers;

use Craft;
use craft\web\Controller;
use stubr\Plugin;

class PromptsController extends Controller{

    public function actionIndex(){

        $settings = Plugin::$plugin->getSettings();
        $prompts = $settings->prompts;
        $allFields = Craft::$app->getFields()->getAllFields();
        $savedOrder = $settings->fieldOrder;

        if (!empty($savedOrder)) {
            $positions = array_flip($savedOrder);
            usort($allFields, function ($a, $b) use ($positions) {
                $posA = $positions[$a->handle] ?? PHP_INT_MAX;
                $posB = $positions[$b->handle] ?? PHP_INT_MAX;
                return $posA <=> $posB;
            });
        }

        $fieldAssignments = $settings->fieldAssignments;

        return $this->renderTemplate('craft-cp-ai/index', [
            'prompts' => $prompts,
            'allFields' => $allFields,
            'fieldAssignments' => $fieldAssignments,
            'settings' => $settings,
        ]);
    }

    public function actionSave(){
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();
        $prompts = $request->getBodyParam('prompts', []);
        $fieldAssignments = $request->getBodyParam('fieldAssignments', []);
        $fieldOrderJson = $request->getBodyParam('fieldOrder', '');
        $fieldOrder = $fieldOrderJson ? (json_decode($fieldOrderJson, true) ?: []) : [];
        $buckets = $request->getBodyParam('bucketAssignments', []);

        $plainTextKeys = $buckets['allPlainText'] ?? [];
        $ckEditorKeys = $buckets['allCKEditor']  ?? [];

        foreach ($prompts as $key => $prompt) {
            $key = (string)$key;
            $prompts[$key]['allPlainText'] = in_array($key, $plainTextKeys, true) ? '1' : '';
            $prompts[$key]['allCKEditor'] = in_array($key, $ckEditorKeys,  true) ? '1' : '';
        }

        $settings = Plugin::$plugin->getSettings();
        $settings->prompts = $prompts;

        Craft::$app->getPlugins()->savePluginSettings(Plugin::$plugin, [
            'prompts' => $prompts,
            'fieldAssignments' => $fieldAssignments,
            'fieldOrder' => $fieldOrder,
        ]);

        return $this->redirect('craft-cp-ai/prompts');
    }
}