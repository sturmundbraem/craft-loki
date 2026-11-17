# Changelog

## 0.4.0 - 2026-11-16
- Added "Allow prompt editing only for admin users" option to the plugin settings (stored in the database and saved instantly, so admins can change it on every environment; default: off).
- Prompts can now be edited on all environments, including where admin changes are disallowed.
- Non-admin users can edit prompts unless the admin-only option is on, in which case they see the page read-only.
- Added German, French and Italian translations for the control panel UI. Each user sees their own CP language.
- Default prompt labels are translated into each user's language. Custom labels are shown as entered.
- Added "Correct quotes" default prompt (Swiss German/Italian «…» ‹…›, French « … » ‹ … ›, English “…” ‘…’). Existing installs get it via migration.
- Custom prompts (label and instruction) are translated with DeepL into German, French, Italian and English when the Prompts page is saved. Editors see the label in their CP language, and the AI gets the instruction in that language. Only new or changed prompts are sent to DeepL.
- AI prompts now always write in the site's language (e.g. German on a de-CH site), unless the prompt asks for a different language.
- Fixed DeepL requests failing with DeepL Pro API keys (the Free API host was always used).
- Fixed prompts not saving on fresh installs ("table does not exist"). Added an install migration, plus a migration that creates the missing table on affected installs.

## 0.3.2 - 2026-06-22
- Various fixes.

## 0.3.0 - 2026-06-18
- Various fixes.

## 0.1.0 - 2026-06-13
- Initial plugin release.
