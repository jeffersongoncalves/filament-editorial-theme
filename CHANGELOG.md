# Changelog

All notable changes to this project will be documented in this file.

## 1.5.0 - 2026-10-08

The terminal login no longer types out its lines after the page loads: the prompt lines and form render right away (the blinking cursor stays). Removed the now-unused intro config keys: session_key, type_speed_ms, pause_after_ms, start_delay_ms.

## 1.4.0 - 2026-10-08

Login: light/dark toggle next to the clock, spacing for plugins rendered after the form, page fits the viewport (no extra padding, keeps Filament's min-h-dvh).

## 1.3.2 - 2026-10-08

Fix: no forced scrollbar on the login page.

## 1.3.1 - 2026-10-08

Fix: readable login in the light scheme (paper scrim instead of the dark one).

## 1.3.0 - 2026-10-08

fonts() now sets the panel font to the bundled DM Sans (no font CDN); fonts(false) keeps your own.

## 1.2.1 - 2026-10-08

Fix: the terminal login renders the login form hooks, so plugins like developer logins or social buttons show up.

## 1.2.0 - 2026-10-08

Login and status strings in 19 languages.

## 1.1.0 - 2026-10-07

Filament 3 support: the 1.x line now targets Filament 3 / Tailwind 3. 1.0.0 was a Filament 5 build — on Filament 5 use ^3.0.

## 1.0.0 - 2026-10-07

First release for Filament 5.x.
