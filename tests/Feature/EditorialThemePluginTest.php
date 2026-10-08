<?php

use Filament\Facades\Filament;
use Filament\FontProviders\LocalFontProvider;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin;
use JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth\Login;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('test'));
    Filament::bootCurrentPanel();
});

it('registers the editorial palettes and the brand on the panel', function () {
    $panel = Filament::getPanel('test');

    expect($panel->getBrandName())->toBe('Acme Admin')
        ->and($panel->getLoginRouteAction())->toBe(Login::class);
});

it('lets the primary color be overridden', function () {
    $panel = Filament::getPanel('test');
    EditorialThemePlugin::make()->primaryColor(['500' => '#00ff00'])->register($panel);

    expect(Filament::getPanel('test')->getColors()['primary'])->toBe(['500' => '#00ff00']);
});

it('renders the footer and the sidebar status with the configured values', function () {
    $footer = (string) FilamentView::renderHook(PanelsRenderHook::FOOTER);
    $status = (string) FilamentView::renderHook(PanelsRenderHook::SIDEBAR_FOOTER);

    expect($footer)->toContain('© Acme Corp')->toContain('made with care')
        ->and($status)->toContain('v1.2.3')->toContain('local');
});

it('opens external links in a new tab', function () {
    expect((string) FilamentView::renderHook(PanelsRenderHook::BODY_END))->toContain("a.target = '_blank'");
});

it('overrides the paper grain and text-on-accent tokens', function () {
    expect((string) FilamentView::renderHook(PanelsRenderHook::HEAD_END))
        ->toContain('<style>:root, .fi-body { --paper-grain-opacity: 0.03; --text-on-accent: #000; }</style>');
});

it('clamps and escapes the token overrides', function () {
    $css = EditorialThemePlugin::make()->paperGrain(4)->textOnAccent('</style><script>')->tokenOverrides();

    expect($css)->toContain('--paper-grain-opacity: 1;')
        ->not->toContain('<script>');
});

it('adds no token style when nothing is overridden', function () {
    $panel = Filament::getPanel('test');
    $plugin = EditorialThemePlugin::make();

    expect($plugin->getPaperGrainOpacity())->toBeNull()
        ->and($plugin->getTextOnAccent())->toBeNull()
        ->and($plugin->fonts()->scrollbar())->toBe($plugin);
});

it('renders the terminal login', function () {
    Livewire::test(Login::class)
        ->assertSuccessful()
        ->assertSee('restricted area')
        ->assertSee('login --required');
});

it('translates the partials', function () {
    app()->setLocale('pt_BR');

    expect(__('filament-editorial-theme::status.label'))->not->toBe('filament-editorial-theme::status.label');
});

it('renders the login form hooks plugins rely on', function () {
    FilamentView::registerRenderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, fn () => 'hook-before-form');
    FilamentView::registerRenderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, fn () => 'hook-after-form');

    Livewire::test(Login::class)
        ->assertSee('hook-before-form')
        ->assertSee('hook-after-form');
});

it('registers the bundled fonts on the panel without a CDN link', function () {
    $panel = Filament::getPanel('test');

    expect($panel->getFontFamily())->toBe('DM Sans')
        ->and($panel->getMonoFontFamily())->toBe('JetBrains Mono')
        ->and($panel->getSerifFontFamily())->toBe('Fraunces')
        ->and($panel->getFontProvider())->toBe(LocalFontProvider::class)
        ->and((string) $panel->getFontHtml())->not->toContain('<link');
});

it('leaves the panel fonts alone with fonts(false)', function () {
    $panel = (new Panel)->id('other');
    EditorialThemePlugin::make()->fonts(false)->register($panel);

    expect($panel->getFontFamily())->not->toBe('DM Sans');
});

it('puts a light/dark theme toggle next to the clock', function () {
    Livewire::test(Login::class)
        ->assertSeeHtml('login-theme-toggle')
        ->assertSeeHtml("\$dispatch('theme-changed'");
});

it('spaces the after-form hook output only when there is some', function () {
    expect(Livewire::test(Login::class)->html())->not->toContain('class="login-form-after"');

    FilamentView::registerRenderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, fn () => 'dev-logins');

    Livewire::test(Login::class)->assertSeeHtml('<div class="login-form-after">dev-logins</div>');
});

it('shows the terminal lines right away, without a typewriter intro', function () {
    Livewire::test(Login::class)
        ->assertSee(__('filament-editorial-theme::login.whoami_unauth'))
        ->assertDontSeeHtml('data-typewriter');
});
