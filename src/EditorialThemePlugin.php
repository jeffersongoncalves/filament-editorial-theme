<?php

namespace JeffersonGoncalves\FilamentEditorialTheme;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;

class EditorialThemePlugin implements Plugin
{
    protected array $primaryColor = [];

    protected ?string $logo = null;

    protected ?string $brandName = null;

    protected bool $terminalLogin = false;

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

    public function logo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function brandName(string $name): static
    {
        $this->brandName = $name;

        return $this;
    }

    public function terminalLogin(bool $enabled = true): static
    {
        $this->terminalLogin = $enabled;

        return $this;
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
            'primary' => $this->primaryColor !== [] ? $this->primaryColor : Color::Amber,
        ]);

        if ($this->logo !== null) {
            $panel->brandLogo($this->logo);
        }

        if ($this->brandName !== null) {
            $panel->brandName($this->brandName);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
