@php
    $plugin = \JeffersonGoncalves\FilamentEditorialTheme\EditorialThemePlugin::get();
    $copyright = $plugin->getFooterCopyright()
        ?? '© ' . date('Y') . ' · ' . config('app.name');
    $right = $plugin->getFooterRight() ?? '';
@endphp

<footer class="px-6 py-4" style="border-top: 1px solid var(--color-ink-800); font-family: var(--font-mono); font-size: 11px; color: var(--color-ink-500); letter-spacing: 0.04em;">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <span>{!! $copyright !!}</span>
        <span>{!! $right !!}</span>
    </div>
</footer>
