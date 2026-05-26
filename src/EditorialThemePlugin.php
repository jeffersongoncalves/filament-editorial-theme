<?php

namespace JeffersonGoncalves\FilamentEditorialTheme;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\View;
use JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth\Login;

class EditorialThemePlugin implements Plugin
{
    public const PRIMARY = [
        50 => '#FFFBEB',
        100 => '#FEF3C7',
        200 => '#FDE68A',
        300 => '#FCD34D',
        400 => '#FBBF24',
        500 => '#F59E0B',
        600 => '#D97706',
        700 => '#B45309',
        800 => '#92400E',
        900 => '#78350F',
        950 => '#451A03',
    ];

    public const GRAY = [
        50 => '#F8F5EE',
        100 => '#F0EBDF',
        200 => '#D9D2C5',
        300 => '#B8B0A4',
        400 => '#8B8377',
        500 => '#5C5349',
        600 => '#3D362F',
        700 => '#2A2620',
        800 => '#1F1B17',
        900 => '#13110E',
        950 => '#0B0A09',
    ];

    protected array $primaryColor = [];

    protected array $grayColor = [];

    protected string|Htmlable|Closure|null $logo = null;

    protected string|Closure|null $brandName = null;

    protected bool $terminalLogin = false;

    protected bool $footer = true;

    protected string|Htmlable|Closure|null $footerCopyright = null;

    protected string|Htmlable|Closure|null $footerRight = null;

    protected bool $sidebarStatus = true;

    protected string|Htmlable|Closure|null $sidebarStatusVersion = null;

    protected bool $externalLinks = true;

    protected bool $fontsLocal = true;

    protected int $scrollbarSize = 6;

    protected bool $scrollbarAccent = true;

    protected float $paperGrainOpacity = 0.06;

    protected ?string $textOnAccent = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return 'editorial-theme';
    }

    public function primaryColor(array $color): static
    {
        $this->primaryColor = $color;

        return $this;
    }

    public function grayColor(array $color): static
    {
        $this->grayColor = $color;

        return $this;
    }

    public function logo(string|Htmlable|Closure|null $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function brandName(string|Closure $name): static
    {
        $this->brandName = $name;

        return $this;
    }

    public function terminalLogin(bool $enabled = true): static
    {
        $this->terminalLogin = $enabled;

        return $this;
    }

    public function footer(bool $enabled = true): static
    {
        $this->footer = $enabled;

        return $this;
    }

    public function footerCopyright(string|Htmlable|Closure|null $value): static
    {
        $this->footerCopyright = $value;

        return $this;
    }

    public function footerRight(string|Htmlable|Closure|null $value): static
    {
        $this->footerRight = $value;

        return $this;
    }

    public function sidebarStatus(bool $enabled = true): static
    {
        $this->sidebarStatus = $enabled;

        return $this;
    }

    public function sidebarStatusVersion(string|Htmlable|Closure|null $value): static
    {
        $this->sidebarStatusVersion = $value;

        return $this;
    }

    public function externalLinks(bool $enabled = true): static
    {
        $this->externalLinks = $enabled;

        return $this;
    }

    public function getFooterCopyright(): string|Htmlable|null
    {
        return $this->resolveValue($this->footerCopyright);
    }

    public function getFooterRight(): string|Htmlable|null
    {
        return $this->resolveValue($this->footerRight);
    }

    public function getSidebarStatusVersion(): string|Htmlable|null
    {
        return $this->resolveValue($this->sidebarStatusVersion);
    }

    protected function resolveValue(string|Htmlable|Closure|null $value): string|Htmlable|null
    {
        return $value instanceof Closure ? $value() : $value;
    }

    public function fonts(bool $local = true): static
    {
        $this->fontsLocal = $local;

        return $this;
    }

    public function scrollbar(int $size = 6, bool $accent = true): static
    {
        $this->scrollbarSize = $size;
        $this->scrollbarAccent = $accent;

        return $this;
    }

    public function paperGrain(float $opacity = 0.06): static
    {
        $this->paperGrainOpacity = $opacity;

        return $this;
    }

    public function textOnAccent(string $color): static
    {
        $this->textOnAccent = $color;

        return $this;
    }

    public function isTerminalLoginEnabled(): bool
    {
        return $this->terminalLogin;
    }

    public function getScrollbarSize(): int
    {
        return $this->scrollbarSize;
    }

    public function getPaperGrainOpacity(): float
    {
        return $this->paperGrainOpacity;
    }

    public function getTextOnAccent(): ?string
    {
        return $this->textOnAccent;
    }

    public function register(Panel $panel): void
    {
        $panel->colors([
            'primary' => $this->primaryColor !== [] ? $this->primaryColor : self::PRIMARY,
            'gray' => $this->grayColor !== [] ? $this->grayColor : self::GRAY,
        ]);

        if ($this->logo !== null) {
            $panel->brandLogo($this->logo);
        }

        if ($this->brandName !== null) {
            $panel->brandName($this->brandName);
        }

        if ($this->terminalLogin) {
            $panel
                ->login(Login::class)
                ->renderHook(
                    PanelsRenderHook::BODY_START,
                    fn () => View::make('filament-editorial-theme::partials.login-preview'),
                    scopes: [Login::class],
                );
        }

        if ($this->footer) {
            $panel->renderHook(
                PanelsRenderHook::FOOTER,
                fn () => View::make('filament-editorial-theme::partials.footer'),
            );
        }

        if ($this->sidebarStatus) {
            $panel->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => View::make('filament-editorial-theme::partials.sidebar-status'),
            );
        }

        if ($this->externalLinks) {
            $panel->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => View::make('filament-editorial-theme::partials.external-links'),
            );
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
