<?php

namespace JeffersonGoncalves\FilamentEditorialTheme;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
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

    protected ?float $paperGrainOpacity = null;

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

    /**
     * @deprecated No effect: the fonts are always bundled with the theme CSS. Will be removed in 2.0.
     */
    public function fonts(bool $local = true): static
    {
        return $this;
    }

    /**
     * @deprecated No effect: override the scrollbar in your theme.css. Will be removed in 2.0.
     */
    public function scrollbar(int $size = 6, bool $accent = true): static
    {
        return $this;
    }

    /** Opacity of the paper-grain overlay (theme default: 0.06 dark, 0.04 light). */
    public function paperGrain(float $opacity = 0.06): static
    {
        $this->paperGrainOpacity = $opacity;

        return $this;
    }

    /** Text color on primary (accent) surfaces, e.g. buttons (theme default: ink in dark, white in light). */
    public function textOnAccent(string $color): static
    {
        $this->textOnAccent = $color;

        return $this;
    }

    public function isTerminalLoginEnabled(): bool
    {
        return $this->terminalLogin;
    }

    public function getPaperGrainOpacity(): ?float
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
            'primary' => self::toRgb($this->primaryColor !== [] ? $this->primaryColor : self::PRIMARY),
            'gray' => self::toRgb($this->grayColor !== [] ? $this->grayColor : self::GRAY),
        ]);

        if ($this->logo !== null) {
            $panel->brandLogo($this->logo);
        }

        if ($this->brandName !== null) {
            $panel->brandName($this->brandName);
        }

        if ($this->paperGrainOpacity !== null || $this->textOnAccent !== null) {
            $panel->renderHook(PanelsRenderHook::HEAD_END, fn () => new HtmlString($this->tokenOverrides()));
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

    /**
     * Unlayered, so it beats the theme tokens declared inside @layer components for both schemes.
     */
    public function tokenOverrides(): string
    {
        $tokens = array_filter([
            '--paper-grain-opacity' => $this->paperGrainOpacity !== null ? (string) max(0, min(1, $this->paperGrainOpacity)) : null,
            '--text-on-accent' => $this->textOnAccent !== null ? e($this->textOnAccent) : null,
        ], fn (?string $value) => $value !== null);

        $css = implode(' ', array_map(fn (string $name, string $value) => "{$name}: {$value};", array_keys($tokens), $tokens));

        return "<style>:root, .fi-body { {$css} }</style>";
    }

    /**
     * Filament 3 expects palette shades as "r, g, b" strings (what Color::Amber holds); hex shades are converted.
     *
     * @param  array<int|string, string>  $palette
     * @return array<int|string, string>
     */
    public static function toRgb(array $palette): array
    {
        return array_map(function (string $shade): string {
            if (preg_match('/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $shade, $m) !== 1) {
                return $shade;
            }

            return hexdec($m[1]).', '.hexdec($m[2]).', '.hexdec($m[3]);
        }, $palette);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
