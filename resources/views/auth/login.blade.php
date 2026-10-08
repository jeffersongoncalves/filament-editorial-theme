<x-filament-panels::page.simple>
    <div class="login-terminal-wrapper">
        <div class="editorial-eyebrow login-eyebrow">
            01 · {{ __('filament-editorial-theme::login.eyebrow') }}
        </div>

        <div class="login-terminal">
            <div class="login-terminal-bar">
                <span class="login-terminal-dot" style="background: #E26B5C;"></span>
                <span class="login-terminal-dot" style="background: #FBBF24;"></span>
                <span class="login-terminal-dot" style="background: #86C682;"></span>
                <span style="margin-left: 8px;">~/admin — zsh</span>
                <span style="margin-left: auto; color: var(--color-ink-600);">{{ now()->format('H:i') }}</span>
                @if (filament()->hasDarkMode() && ! filament()->hasDarkModeForced())
                    {{-- Same event as Filament's theme switcher: the choice is stored and applies to the whole panel. --}}
                    <button
                        type="button"
                        class="login-theme-toggle"
                        x-data
                        x-on:click="$dispatch('theme-changed', $store.theme === 'dark' ? 'light' : 'dark')"
                        title="{{ __('filament-panels::layout.actions.theme_switcher.label') }}"
                        aria-label="{{ __('filament-panels::layout.actions.theme_switcher.label') }}"
                    >
                        <x-filament::icon icon="heroicon-m-sun" x-show="$store.theme === 'dark'" x-cloak class="login-theme-toggle-icon" />
                        <x-filament::icon icon="heroicon-m-moon" x-show="$store.theme !== 'dark'" x-cloak class="login-theme-toggle-icon" />
                    </button>
                @endif
            </div>

            <div class="login-terminal-body">
                <div class="login-terminal-line">
                    <span class="login-prompt">$</span>
                    <span style="color: var(--color-ink-300);">whoami</span>
                </div>
                <div class="login-terminal-line" style="color: var(--color-ink-400); margin-bottom: 14px;">{{ __('filament-editorial-theme::login.whoami_unauth') }}</div>

                <div class="login-terminal-line">
                    <span class="login-prompt">$</span>
                    <span style="color: var(--color-ink-300);">login --required</span><span class="login-cursor"></span>
                </div>

                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                <form wire:submit="authenticate" class="login-form login-terminal-form">
                    {{ $this->form }}

                    <div style="margin-top: 20px;">
                        {{ $this->getAuthenticateFormAction() }}
                    </div>
                </form>

                {{-- Plugins hook in here (developer logins, social login buttons...); spaced from the button
                     only when something is rendered, so an empty hook doesn't add a gap. --}}
                @php($loginFormAfter = (string) \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()))
                @if (filled(trim($loginFormAfter)))
                    <div class="login-form-after">{!! $loginFormAfter !!}</div>
                @endif

                <div class="login-terminal-status">
                    <span class="editorial-pulse"></span>
                    <span>{{ __('filament-editorial-theme::login.secure_connection') }} · {{ request()->getHost() }}</span>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <a href="{{ config('app.url') }}">← {{ __('filament-editorial-theme::login.back_to_site') }}</a>
            <span class="sep">·</span>
            <span>{{ config('app.name') }}</span>
        </div>
    </div>

    @push('scripts')
        <script>
            // No-op Alpine stubs for site components inlined into the login preview.
            // Prevents ReferenceErrors from leaking into the admin console.
            document.addEventListener('alpine:init', () => {
                window.Alpine.data('stickyHeader',    () => ({ scrolled: false, init() {} }));
                window.Alpine.data('terminalTyping',  () => ({ typed: '', typingDone: false, init() {} }));
                window.Alpine.data('countUp',         () => ({ stats: {}, init() {} }));
                window.Alpine.data('heatmap',         () => ({ cells: [], init() {} }));
                window.Alpine.data('markdownCopy',    () => ({ init() {} }));
            });
        </script>
    @endpush
</x-filament-panels::page.simple>
