## Filament Editorial Theme

Editorial Terminal theme for Filament 5: bundled Fraunces / DM Sans / JetBrains Mono, ink/paper/amber palette (dark + light), footer and sidebar-status partials and an optional terminal login.

### Installation

@verbatim
<code-snippet name="Install" lang="bash">
composer require jeffersongoncalves/filament-editorial-theme:"^1.0"
</code-snippet>
@endverbatim

@verbatim
<code-snippet name="Panel theme CSS" lang="css">
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@import '../../../../vendor/jeffersongoncalves/filament-editorial-theme/resources/css/theme.css';
@source '../../../../vendor/jeffersongoncalves/filament-editorial-theme/resources/views';
</code-snippet>
@endverbatim

### Register Plugin

@verbatim
<code-snippet name="Register in PanelProvider" lang="php">
use JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin;

$panel
    ->viteTheme('resources/css/filament/admin/theme.css')
    ->plugin(
        EditorialThemePlugin::make()
            ->brandName('Acme')
            ->terminalLogin()
            ->sidebarStatusVersion(fn () => config('app.version')),
    );
</code-snippet>
@endverbatim

### Rules
- The panel must use a Vite theme that imports the package CSS and `@source`s its views, or the partials lose their Tailwind utilities.
- Customize colors/fonts by overriding CSS tokens below the import; use `paperGrain()` / `textOnAccent()` for those two tokens.
- `fonts()` and `scrollbar()` are deprecated no-ops — don't use them.
- Keep the desktop-only sidebar fixes and `min-height: 0` on `.fi-sidebar-nav` when copying CSS.
