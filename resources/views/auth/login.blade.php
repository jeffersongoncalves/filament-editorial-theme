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
            </div>

            <div class="login-terminal-body">
                <div class="login-terminal-line">
                    <span class="login-prompt">$</span>
                    <span style="color: var(--color-ink-300);" data-typewriter="whoami"></span><span class="login-cursor" data-cursor="1"></span>
                </div>
                <div class="login-terminal-line" style="color: var(--color-ink-400); margin-bottom: 14px; min-height: 1.7em;" data-typewriter-line="2" data-typewriter="{{ __('filament-editorial-theme::login.whoami_unauth') }}"></div>

                <div class="login-terminal-line">
                    <span class="login-prompt" data-prompt="3" style="opacity: 0;">$</span>
                    <span style="color: var(--color-ink-300);" data-typewriter-line="3" data-typewriter="login --required"></span><span class="login-cursor" data-cursor="3"></span>
                </div>

                <form wire:submit="authenticate" class="login-form login-terminal-form" data-typewriter-form>
                    {{ $this->form }}

                    <div style="margin-top: 20px;">
                        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
                    </div>
                </form>

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

        <script>
            (function () {
                const TYPE_SPEED = 55;
                const PAUSE_AFTER = 320;
                const START_DELAY = 1500;
                const SEEN_KEY = 'editorial-login-intro-seen';

                function typeInto(el, text, speed) {
                    return new Promise((resolve) => {
                        let i = 0;
                        const tick = () => {
                            if (i <= text.length) {
                                el.textContent = text.slice(0, i);
                                i++;
                                setTimeout(tick, speed);
                            } else {
                                resolve();
                            }
                        };
                        tick();
                    });
                }

                function wait(ms) {
                    return new Promise((r) => setTimeout(r, ms));
                }

                function revealForm() {
                    const line1 = document.querySelector('[data-typewriter="whoami"]');
                    const line2 = document.querySelector('[data-typewriter-line="2"]');
                    const line3 = document.querySelector('[data-typewriter-line="3"]');
                    const cursor1 = document.querySelector('[data-cursor="1"]');
                    const cursor3 = document.querySelector('[data-cursor="3"]');
                    const prompt3 = document.querySelector('[data-prompt="3"]');
                    const form = document.querySelector('[data-typewriter-form]');

                    if (line1) line1.textContent = line1.dataset.typewriter;
                    if (line2) line2.textContent = line2.dataset.typewriter;
                    if (line3) line3.textContent = line3.dataset.typewriter;
                    if (cursor1) cursor1.style.display = 'none';
                    if (cursor3) cursor3.style.display = 'inline-block';
                    if (prompt3) prompt3.style.opacity = '1';
                    if (form) form.style.opacity = '1';
                }

                async function run() {
                    const line1 = document.querySelector('[data-typewriter="whoami"]');
                    const line2 = document.querySelector('[data-typewriter-line="2"]');
                    const line3 = document.querySelector('[data-typewriter-line="3"]');
                    const cursor1 = document.querySelector('[data-cursor="1"]');
                    const cursor3 = document.querySelector('[data-cursor="3"]');
                    const form = document.querySelector('[data-typewriter-form]');

                    if (!line1 || !line2 || !line3) return;

                    // Fast-path: skip intro if user already saw it this session
                    let seen = false;
                    try { seen = sessionStorage.getItem(SEEN_KEY) === '1'; } catch (e) {}
                    if (seen) {
                        revealForm();
                        return;
                    }

                    // Reset
                    line1.textContent = '';
                    line2.textContent = '';
                    line3.textContent = '';
                    if (form) form.style.opacity = '0';
                    if (cursor3) cursor3.style.display = 'none';

                    await wait(START_DELAY);

                    await typeInto(line1, line1.dataset.typewriter, TYPE_SPEED);
                    if (cursor1) cursor1.style.display = 'none';
                    await wait(PAUSE_AFTER);

                    await typeInto(line2, line2.dataset.typewriter, TYPE_SPEED);
                    await wait(PAUSE_AFTER);

                    const prompt3 = document.querySelector('[data-prompt="3"]');
                    if (prompt3) prompt3.style.opacity = '1';
                    if (cursor3) cursor3.style.display = 'inline-block';
                    await typeInto(line3, line3.dataset.typewriter, TYPE_SPEED);
                    await wait(PAUSE_AFTER);

                    if (form) {
                        form.style.transition = 'opacity 400ms cubic-bezier(0.22, 1, 0.36, 1)';
                        form.style.opacity = '1';
                    }

                    try { sessionStorage.setItem(SEEN_KEY, '1'); } catch (e) {}

                    await wait(450);

                    const input = document.querySelector('.login-terminal input[type="email"], .login-terminal input[name="email"]');
                    if (input) input.focus({ preventScroll: true });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', run);
                } else {
                    run();
                }

                // Re-reveal after Livewire morph (validation failure round-trip)
                document.addEventListener('livewire:navigated', revealForm);
                document.addEventListener('livewire:initialized', () => {
                    if (window.Livewire && window.Livewire.hook) {
                        window.Livewire.hook('morph.updated', revealForm);
                        window.Livewire.hook('commit', ({ succeed }) => {
                            succeed(() => revealForm());
                        });
                    }
                });
            })();
        </script>
    @endpush
</x-filament-panels::page.simple>
