<div class="filament-hidden">

![Filament Editorial Theme](https://raw.githubusercontent.com/jeffersongoncalves/filament-editorial-theme/2.x/art/jeffersongoncalves-filament-editorial-theme.png)

</div>

# Filament Editorial Theme

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-support-FFDD00?style=flat-square&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/jeffersongoncalves)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-editorial-theme.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-editorial-theme)
[![Tests](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-editorial-theme/tests.yml?branch=2.x&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/filament-editorial-theme/actions?query=workflow%3ATests+branch%3A2.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-editorial-theme.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-editorial-theme)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/filament-editorial-theme.svg?style=flat-square)](LICENSE.md)

**Editorial Terminal** — a paper + terminal theme for Filament 3, 4 and 5, the one behind [jeffersongoncalves.dev.br](https://jeffersongoncalves.dev.br).

- Fraunces (display), DM Sans (UI) and JetBrains Mono (code), bundled — no Google Fonts request
- Ink / paper / amber palette with dark (default) and light schemes driven by semantic tokens
- Paper-grain overlay, amber scrollbars, sidebar layout fixes for Livewire morphing
- Footer and sidebar-status partials, external links opened in a new tab
- Optional terminal-style login with a light/dark toggle

## Compatibility

| Branch | Filament | Package version |
|--------|----------|-----------------|
| 1.x | 3.x | `^1.1` |
| 2.x | 4.x | `^2.0` |
| 3.x | 5.x | `^3.0` |

> `1.0.0` was a Filament 5 build published before the branches were split — on Filament 5 require `^3.0`.

## Starter kits

Start a new project with the theme already wired in: admin, app and guest panels, multi-auth, terminal login and developer logins.

| Kit | Filament | Install |
|-----|----------|---------|
| [EditorialTheme v5](https://github.com/jeffersongoncalves/editorialthemev5) | 5.x | `composer create-project jeffersongoncalves/editorialthemev5 my-app` |
| [EditorialTheme v4](https://github.com/jeffersongoncalves/editorialthemev4) | 4.x | `composer create-project jeffersongoncalves/editorialthemev4 my-app` |
| [EditorialTheme v3](https://github.com/jeffersongoncalves/editorialthemev3) | 3.x | `composer create-project jeffersongoncalves/editorialthemev3 my-app` |

## Installation

```bash
composer require jeffersongoncalves/filament-editorial-theme:"^2.0"
```

The theme ships as CSS that your panel's Vite theme imports. If the panel has no custom theme yet, create one with `php artisan make:filament-theme`, then make `resources/css/filament/admin/theme.css` look like this:

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@import '../../../../vendor/jeffersongoncalves/filament-editorial-theme/resources/css/theme.css';

/* Tailwind v4 only keeps utilities found in @source files: include the theme's partials. */
@source '../../../../vendor/jeffersongoncalves/filament-editorial-theme/resources/views';

@source '../../../../app/Filament';
@source '../../../../resources/views/filament';

/* Your overrides below */
```

Make sure the file is a Vite input and the panel uses it (`->viteTheme('resources/css/filament/admin/theme.css')`), then build with `pnpm run build` (or `npm run build`).

## Usage

```php
use JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->viteTheme('resources/css/filament/admin/theme.css')
        ->plugin(
            EditorialThemePlugin::make()
                ->logo(fn () => asset('img/logo.svg'))
                ->brandName('Acme Inc.')
                ->terminalLogin(),
        );
}
```

### Options

| Method | Default | |
|---|---|---|
| `primaryColor(array $color)` | amber | Panel primary palette (e.g. `Color::Green`) |
| `grayColor(array $color)` | ink/paper | Panel gray palette |
| `logo(string\|Htmlable\|Closure)` / `brandName(string\|Closure)` | — | Shortcuts for the panel brand |
| `terminalLogin(bool)` | off | Terminal-style login page (`Pages\Auth\Login`) |
| `footer(bool)` | on | Footer partial |
| `footerCopyright(…)` / `footerRight(…)` | `© {year} · {app.name}` / empty | Footer contents (string, HTML or Closure) |
| `sidebarStatus(bool)` | on | "status · production/local" block pinned to the bottom of the sidebar |
| `sidebarStatusVersion(…)` | — | Version shown next to the status, e.g. `fn () => config('app.version')` |
| `externalLinks(bool)` | on | Open cross-host links in a new tab (`noopener noreferrer`) |
| `fonts(bool)` | on | Use the bundled DM Sans / JetBrains Mono / Fraunces as the panel fonts (no font CDN); `false` keeps the fonts you set with `->font()` |
| `paperGrain(float $opacity)` | 0.06 dark / 0.04 light | Paper-grain overlay opacity |
| `textOnAccent(string $color)` | ink (dark) / `#fff` (light) | Text color on primary buttons — set it when your `primaryColor()` needs a different contrast |

Everything else is a CSS token: override `--surface-*`, `--text-*`, `--accent`, the fonts (`--font-serif`, `--font-sans`, `--font-mono` in an `@theme` block) and the rest below the `@import` in your theme file.

### Terminal login

`->terminalLogin()` swaps the panel login for the bundled page. To customize it, extend it and point the panel at your class:

```php
namespace App\Filament\Admin\Pages\Auth;

class Login extends \JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth\Login
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [...parent::getCredentialsFromFormData($data), 'status' => true];
    }
}

$panel->login(\App\Filament\Admin\Pages\Auth\Login::class);
```

Behind the terminal you can show a blurred preview of any view (your public homepage, for instance) — publish the config and set `login.preview_view`:

```bash
php artisan vendor:publish --tag=filament-editorial-theme-config
```

The login and status strings ship in 19 languages (ar, az, de, en, es, fa, fr, hi, it, ja, nl, pl, pt, pt_BR, ru, tr, uk, uz, zh_CN).

## Gotchas

The theme includes layout fixes that look unusual but exist for concrete reasons — keep them if you copy the CSS:

- **Sidebar layout fixes are desktop-only** (`@media (min-width: 1024px)`): on mobile the sidebar is a drawer; pinning the wrapper to 81px would leave an empty gutter.
- **`min-height: 0` on `.fi-sidebar-nav`** is what lets `overflow-y: auto` clip — without it the sidebar footer scrolls off-screen.
- **`--text-on-accent` is `#fff` in the light scheme** because amber-600 is too dark for ink text to read well.
- **Outlined primary buttons** keep `currentColor` icons instead of `--text-on-accent`, so the icon matches the label on a transparent background.
- **Scrollbars use tokens** (`--accent` on `--surface-base`) — they're part of the visual identity.

## Requirements

- PHP 8.2 or higher
- Filament 4.x

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. The bundled fonts are licensed under the SIL Open Font License 1.1 — see [resources/fonts/OFL.md](resources/fonts/OFL.md).
