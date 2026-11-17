<?php

// Italian translations. Also used for it-CH etc.
return [
    // Navigation
    'Prompts' => 'Prompt',
    'Settings' => 'Impostazioni',

    // Default prompt labels
    'Translate to DE' => 'Traduci in DE',
    'Translate to current language' => 'Traduci nella lingua corrente',
    'Correct' => 'Correggi',
    'Shorten' => 'Accorcia',
    'Correct quotes' => 'Correggi virgolette',

    // Wand menu (fieldHelper.js)
    '{label} (Draft)' => '{label} (bozza)',
    'Draft created!' => 'Bozza creata!',
    'Field filled — review and save when ready.' => 'Campo compilato – controlla e salva.',
    'Error: {message}' => 'Errore: {message}',
    'Server returned {status}' => 'Il server ha risposto {status}',

    // Controller messages
    'Invalid prompt' => 'Prompt non valido',
    'Invalid provider' => 'Provider non valido',
    'Element not found' => 'Elemento non trovato',
    'Invalid field' => 'Campo non valido',
    'Could not locate target element in the draft.' => 'Impossibile trovare l’elemento di destinazione nella bozza.',
    'Prompt editing is now limited to admins.' => 'Ora solo gli admin possono modificare i prompt.',
    'Prompt editing is now open to all users.' => 'Ora tutti gli utenti possono modificare i prompt.',
    'User is not permitted to edit prompts.' => 'L’utente non è autorizzato a modificare i prompt.',

    'Prompts saved, but custom prompts were not translated: no DeepL API key configured.' => 'Prompt salvati, ma i prompt personalizzati non sono stati tradotti: nessuna chiave API DeepL configurata.',
    'Prompts saved, but custom prompts could not be translated: {error}' => 'Prompt salvati, ma non è stato possibile tradurre i prompt personalizzati: {error}',

    // Plugin settings page
    'System Prompt' => 'Prompt di sistema',
    'Sent to the AI as the system role. Supports Twig variables like {siteLang} and {entryTitle}.' => 'Inviato all’IA come ruolo di sistema. Supporta variabili Twig come {siteLang} e {entryTitle}.',
    '{provider} API Key' => 'Chiave API {provider}',
    'Either paste your {provider} key directly, or reference an environment variable like {envVar}.' => 'Incolla direttamente la tua chiave {provider} oppure indica una variabile d’ambiente come {envVar}.',
    'Allow prompt editing only for admin users' => 'Consenti la modifica dei prompt solo agli admin',
    'When off, every user can edit prompts. When on, non-admin users see the Prompts page read-only. Saved immediately, on every environment.' => 'Se disattivato, tutti gli utenti possono modificare i prompt. Se attivato, i non admin vedono la pagina dei prompt in sola lettura. Salvato subito, in ogni ambiente.',

    // Prompts page
    'AI Prompts' => 'Prompt IA',
    'Save prompt settings' => 'Salva i prompt',
    'Define your custom AI prompts' => 'Definisci i tuoi prompt IA personalizzati',
    'DeepL prompts are sent as the API {targetLang} value. Use the exact syntax from {apiDocs} and {languageList}, for example {examples}.' => 'I prompt DeepL vengono inviati come valore {targetLang} dell’API. Usa la sintassi esatta della {apiDocs} e dell’{languageList}, per esempio {examples}.',
    "DeepL's Translate API docs" => 'documentazione dell’API Translate di DeepL',
    'supported languages list' => 'elenco delle lingue supportate',
    'Default prompt labels are shown in each user’s language. Custom prompts are translated with DeepL when you save.' => 'Le etichette dei prompt predefiniti vengono mostrate nella lingua di ogni utente. I prompt personalizzati vengono tradotti con DeepL al salvataggio.',
    'Prompt' => 'Prompt',
    'Label' => 'Etichetta',
    'Provider' => 'Provider',
    'Tier' => 'Livello',
    'Easy' => 'Facile',
    'Medium' => 'Medio',
    'Hard' => 'Difficile',
    'Create draft' => 'Crea bozza',
    'Add prompt' => 'Aggiungi prompt',
    'Assign prompts to fields' => 'Assegna i prompt ai campi',
    'Fields' => 'Campi',
    'All Plaintext fields' => 'Tutti i campi di testo',
    'All Richtext fields' => 'Tutti i campi Rich Text',
    'Select a field to see its prompts' => 'Seleziona un campo per vederne i prompt',
    '(unnamed)' => '(senza nome)',
    'DeepL: only add target_lang' => 'DeepL: indica solo target_lang',
];
