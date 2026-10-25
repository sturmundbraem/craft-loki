<?php

// French translations. Also used for fr-CH, fr-CA etc.
// \u{00A0} = non-breaking space, required before ":" and "!" in French
return [
    // Navigation
    'Prompts' => 'Prompts',
    'Settings' => 'Paramètres',

    // Default prompt labels
    'Translate to DE' => 'Traduire en DE',
    'Translate to current language' => 'Traduire dans la langue actuelle',
    'Correct' => 'Corriger',
    'Shorten' => 'Raccourcir',
    'Correct quotes' => 'Corriger les guillemets',

    // Wand menu (fieldHelper.js)
    '{label} (Draft)' => '{label} (brouillon)',
    'Draft created!' => "Brouillon créé\u{00A0}!",
    'Field filled — review and save when ready.' => 'Champ rempli – vérifiez puis enregistrez.',
    'Error: {message}' => "Erreur\u{00A0}: {message}",
    'Server returned {status}' => 'Le serveur a répondu {status}',

    // Controller messages
    'Invalid prompt' => 'Prompt invalide',
    'Invalid provider' => 'Fournisseur invalide',
    'Element not found' => 'Élément introuvable',
    'Invalid field' => 'Champ invalide',
    'Could not locate target element in the draft.' => 'Impossible de trouver l’élément cible dans le brouillon.',
    'Prompt editing is now limited to admins.' => 'La modification des prompts est désormais réservée aux admins.',
    'Prompt editing is now open to all users.' => 'La modification des prompts est désormais ouverte à tous les utilisateurs.',
    'User is not permitted to edit prompts.' => 'L’utilisateur n’est pas autorisé à modifier les prompts.',

    'Prompts saved, but custom prompts were not translated: no DeepL API key configured.' => "Prompts enregistrés, mais les prompts personnalisés n’ont pas été traduits\u{00A0}: aucune clé API DeepL configurée.",
    'Prompts saved, but custom prompts could not be translated: {error}' => "Prompts enregistrés, mais les prompts personnalisés n’ont pas pu être traduits\u{00A0}: {error}",

    // Plugin settings page
    'System Prompt' => 'Prompt système',
    'Sent to the AI as the system role. Supports Twig variables like {siteLang} and {entryTitle}.' => 'Envoyé à l’IA comme rôle système. Prend en charge des variables Twig comme {siteLang} et {entryTitle}.',
    '{provider} API Key' => 'Clé API {provider}',
    'Either paste your {provider} key directly, or reference an environment variable like {envVar}.' => 'Collez directement votre clé {provider} ou indiquez une variable d’environnement comme {envVar}.',
    'Allow prompt editing only for admin users' => 'Réserver la modification des prompts aux admins',
    'When off, every user can edit prompts. When on, non-admin users see the Prompts page read-only. Saved immediately, on every environment.' => 'Si désactivé, tous les utilisateurs peuvent modifier les prompts. Si activé, les non-admins voient la page Prompts en lecture seule. Enregistré immédiatement, dans tous les environnements.',

    // Prompts page
    'AI Prompts' => 'Prompts IA',
    'Save prompt settings' => 'Enregistrer les prompts',
    'Define your custom AI prompts' => 'Définissez vos prompts IA personnalisés',
    'DeepL prompts are sent as the API {targetLang} value. Use the exact syntax from {apiDocs} and {languageList}, for example {examples}.' => 'Les prompts DeepL sont envoyés comme valeur {targetLang} de l’API. Utilisez la syntaxe exacte de la {apiDocs} et de la {languageList}, par exemple {examples}.',
    "DeepL's Translate API docs" => 'documentation de l’API Translate de DeepL',
    'supported languages list' => 'liste des langues prises en charge',
    'Default prompt labels are shown in each user’s language. Custom prompts are translated with DeepL when you save.' => 'Les libellés des prompts par défaut s’affichent dans la langue de chaque utilisateur. Les prompts personnalisés sont traduits avec DeepL à l’enregistrement.',
    'Prompt' => 'Prompt',
    'Label' => 'Libellé',
    'Provider' => 'Fournisseur',
    'Tier' => 'Niveau',
    'Easy' => 'Facile',
    'Medium' => 'Moyen',
    'Hard' => 'Difficile',
    'Create draft' => 'Créer un brouillon',
    'Add prompt' => 'Ajouter un prompt',
    'Assign prompts to fields' => 'Attribuer des prompts aux champs',
    'Fields' => 'Champs',
    'All Plaintext fields' => 'Tous les champs texte',
    'All Richtext fields' => 'Tous les champs texte enrichi',
    'Select a field to see its prompts' => 'Sélectionnez un champ pour voir ses prompts',
    '(unnamed)' => '(sans nom)',
    'DeepL: only add target_lang' => "DeepL\u{00A0}: indiquez seulement target_lang",
];
