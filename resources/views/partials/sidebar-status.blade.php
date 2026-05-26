@php
    $plugin = \JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin::get();
    $isProduction = config('app.env') === 'production';
    $version = $plugin->getSidebarStatusVersion();
@endphp

<div class="editorial-sidebar-status px-6 py-4 mt-auto" style="border-top: 1px dashed var(--color-ink-700);">
    <div class="editorial-eyebrow mb-2">{{ __('filament-editorial-theme::status.label') }}</div>
    <div class="flex items-center gap-2" style="font-family: var(--font-mono); font-size: 12px; color: var(--color-ink-300);">
        <span class="editorial-pulse"></span>
        <span>{{ $isProduction ? __('filament-editorial-theme::status.production') : __('filament-editorial-theme::status.local') }}</span>
        @if ($version)
            <span style="color: var(--color-ink-500);">·</span>
            <span style="color: var(--color-ink-500);">v{!! $version !!}</span>
        @endif
    </div>
</div>
