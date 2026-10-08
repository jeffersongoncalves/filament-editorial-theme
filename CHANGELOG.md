# Changelog

All notable changes to this project will be documented in this file.

## 3.4.0 - 2026-10-08

The terminal login no longer types out its lines after the page loads: the prompt lines and form render right away (the blinking cursor stays). Removed the now-unused intro config keys: session_key, type_speed_ms, pause_after_ms, start_delay_ms.

## 3.3.0 - 2026-10-08

Login: light/dark toggle next to the clock, spacing for plugins rendered after the form, page fits the viewport (no extra padding, keeps Filament's min-h-dvh).

## 3.2.2 - 2026-10-08

Fix: no forced scrollbar on the login page.

## 3.2.1 - 2026-10-08

Fix: readable login in the light scheme (paper scrim instead of the dark one).

## 3.2.0 - 2026-10-08

fonts() now sets the panel sans/mono/serif fonts to the bundled DM Sans, JetBrains Mono and Fraunces (no font CDN); fonts(false) keeps your own.

## 3.1.2 - 2026-10-08

Fix: the terminal login renders the login form hooks, so plugins like developer logins or social buttons show up.

## 3.1.1 - 2026-10-08

Fix: drop the sidebar margin overrides that forced a fixed offset on the main content.

## 3.1.0 - 2026-10-08

Login and status strings in 19 languages.

## 3.0.0 - 2026-10-07

First release for Filament 5.x.
