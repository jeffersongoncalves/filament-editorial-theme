# Filament Editorial Theme

> **Editorial Terminal** — a paper + terminal aesthetic theme for Filament v5.
> Custom typography (Fraunces / DM Sans / JetBrains Mono), amber accent palette,
> layout fixes for sidebar morph + scrollbar gutter, and an optional
> terminal-style login screen.

**License:** Proprietary — see [LICENSE.md](LICENSE.md). Commercial license required for production use.

| Branch | Filament | Status |
| ------ | -------- | ------ |
| `1.x`  | v5       | active |

## Install

This package is distributed via a private Composer repository. Add the repo to your `composer.json`:

```json
{
  "repositories": [
    { "type": "composer", "url": "https://packages.jeffersongoncalves.dev.br" }
  ],
  "require": {
    "jeffersongoncalves/filament-editorial-theme": "^1.0"
  }
}
```

Then:

```bash
composer require jeffersongoncalves/filament-editorial-theme
php artisan filament:assets
php artisan vendor:publish --tag=filament-editorial-theme-stubs
php artisan vendor:publish --tag=filament-editorial-theme-fonts
```

## Register on a panel

```php
use JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin;
use Filament\Support\Colors\Color;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(
            EditorialThemePlugin::make()
                ->primaryColor(Color::Amber)
                ->logo('/img/logo.svg')
                ->brandName('Acme Inc.')
                ->terminalLogin(enabled: true)
                ->fonts(local: true)
                ->scrollbar(size: 6, accent: true)
                ->paperGrain(opacity: 0.04)
        );
}
```

## Theme CSS

The `vendor:publish --tag=filament-editorial-theme-stubs` command writes
`resources/css/filament/admin/theme.css` that imports the package CSS. Add your
overrides below the import. Then build assets normally with Vite.

## Terminal login (opt-in)

To use the terminal-style login screen, extend Filament's Login page in your app
and apply the trait:

```php
namespace App\Filament\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    use \JeffersonGoncalves\FilamentEditorialTheme\Concerns\HasTerminalLogin;
}
```

Then point the panel at it:

```php
$panel->login(\App\Filament\Pages\Auth\Login::class);
```

## Gotchas

The theme includes several layout fixes that look unusual but exist for concrete
reasons. Do not remove them blindly:

- **Layout fixes for sidebar morph are desktop-only** (`@media (min-width: 1024px)`).
  On mobile the sidebar renders as a drawer; pinning the wrapper to 81px would
  steal layout space.
- **`min-height: 0` on `.fi-sidebar-nav`** is required for `overflow-y: auto` to
  actually clip — without it the footer scrolls off-screen.
- **`--text-on-accent` is `#fff` in light scheme** because amber-600 is too dark
  for ink-950 text to read with adequate contrast.
- **Outlined primary buttons** use `currentColor` for icons (not `--text-on-accent`)
  so the icon doesn't go ink-950 on a transparent background.
- **Scrollbar uses tokens** (`--accent` / `--surface-base`) — accent color is part
  of the visual identity.

## Support

Commercial licensees receive issue support via email. For sales inquiries,
contact `gerson.simao.92@gmail.com`.
