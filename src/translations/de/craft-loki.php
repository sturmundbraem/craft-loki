<?php

// German translations (Swiss spelling: "ss" instead of "ß"). Also used for de-CH, de-AT etc.
return [
    // Navigation
    'Prompts' => 'Prompts',
    'Settings' => 'Einstellungen',

    // Default prompt labels
    'Translate to DE' => 'Übersetzen nach DE',
    'Translate to current language' => 'In aktuelle Sprache übersetzen',
    'Correct' => 'Korrigieren',
    'Shorten' => 'Kürzen',
    'Correct quotes' => 'Anführungszeichen korrigieren',

    // Wand menu (fieldHelper.js)
    '{label} (Draft)' => '{label} (Entwurf)',
    'Draft created!' => 'Entwurf erstellt!',
    'Field filled — review and save when ready.' => 'Feld ausgefüllt – bitte prüfen und speichern.',
    'Error: {message}' => 'Fehler: {message}',
    'Server returned {status}' => 'Server antwortete mit {status}',

    // Controller messages
    'Invalid prompt' => 'Ungültiger Prompt',
    'Invalid provider' => 'Ungültiger Anbieter',
    'Element not found' => 'Element nicht gefunden',
    'Invalid field' => 'Ungültiges Feld',
    'Could not locate target element in the draft.' => 'Das Zielelement wurde im Entwurf nicht gefunden.',
    'Prompt editing is now limited to admins.' => 'Prompts können jetzt nur noch von Admins bearbeitet werden.',
    'Prompt editing is now open to all users.' => 'Prompts können jetzt von allen Benutzern bearbeitet werden.',
    'User is not permitted to edit prompts.' => 'Der Benutzer darf keine Prompts bearbeiten.',

    'Prompts saved, but custom prompts were not translated: no DeepL API key configured.' => 'Prompts gespeichert, aber eigene Prompts wurden nicht übersetzt: kein DeepL-API-Schlüssel konfiguriert.',
    'Prompts saved, but custom prompts could not be translated: {error}' => 'Prompts gespeichert, aber eigene Prompts konnten nicht übersetzt werden: {error}',

    // Plugin settings page
    'System Prompt' => 'System-Prompt',
    'Sent to the AI as the system role. Supports Twig variables like {siteLang} and {entryTitle}.' => 'Wird der KI als System-Rolle mitgegeben. Unterstützt Twig-Variablen wie {siteLang} und {entryTitle}.',
    '{provider} API Key' => '{provider} API-Schlüssel',
    'Either paste your {provider} key directly, or reference an environment variable like {envVar}.' => 'Fügen Sie Ihren {provider}-Schlüssel direkt ein oder verweisen Sie auf eine Umgebungsvariable wie {envVar}.',
    'Allow prompt editing only for admin users' => 'Bearbeiten von Prompts nur für Admins erlauben',
    'When off, every user can edit prompts. When on, non-admin users see the Prompts page read-only. Saved immediately, on every environment.' => 'Wenn deaktiviert, können alle Benutzer Prompts bearbeiten. Wenn aktiviert, sehen Nicht-Admins die Prompts-Seite nur lesend. Wird sofort gespeichert, in jeder Umgebung.',

    // Prompts page
    'AI Prompts' => 'KI-Prompts',
    'Save prompt settings' => 'Prompt-Einstellungen speichern',
    'Define your custom AI prompts' => 'Eigene KI-Prompts definieren',
    'DeepL prompts are sent as the API {targetLang} value. Use the exact syntax from {apiDocs} and {languageList}, for example {examples}.' => 'DeepL-Prompts werden als API-Wert {targetLang} gesendet. Verwenden Sie die genaue Schreibweise aus der {apiDocs} und der {languageList}, zum Beispiel {examples}.',
    "DeepL's Translate API docs" => 'DeepL-Translate-API-Dokumentation',
    'supported languages list' => 'Liste der unterstützten Sprachen',
    'Default prompt labels are shown in each user’s language. Custom prompts are translated with DeepL when you save.' => 'Die Bezeichnungen der Standard-Prompts erscheinen in der Sprache des jeweiligen Benutzers. Eigene Prompts werden beim Speichern mit DeepL übersetzt.',
    'Prompt' => 'Prompt',
    'Label' => 'Bezeichnung',
    'Provider' => 'Anbieter',
    'Tier' => 'Stufe',
    'Easy' => 'Einfach',
    'Medium' => 'Mittel',
    'Hard' => 'Schwer',
    'Create draft' => 'Entwurf erstellen',
    'Add prompt' => 'Prompt hinzufügen',
    'Assign prompts to fields' => 'Prompts Feldern zuweisen',
    'Fields' => 'Felder',
    'All Plaintext fields' => 'Alle Textfelder',
    'All Richtext fields' => 'Alle Richtext-Felder',
    'Select a field to see its prompts' => 'Wählen Sie ein Feld, um seine Prompts zu sehen',
    '(unnamed)' => '(ohne Namen)',
    'DeepL: only add target_lang' => 'DeepL: nur target_lang angeben',
];
