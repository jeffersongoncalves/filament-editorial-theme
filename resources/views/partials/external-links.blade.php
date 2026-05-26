{{-- External links → new tab inside the Filament admin. Livewire morphs the
     DOM constantly, so beyond the initial pass we watch for subtree changes
     and re-mark. Only cross-host http(s) links get target=_blank + rel
     attrs; panel nav stays in-tab. --}}
<script data-cfasync="false">
    (function () {
        var host = window.location.hostname;

        function mark(root) {
            (root || document).querySelectorAll('a[href]').forEach(function (a) {
                if (a.dataset.extProcessed) return;
                var url;
                try {
                    url = new URL(a.href, window.location.href);
                } catch (e) {
                    return;
                }
                if (url.protocol !== 'http:' && url.protocol !== 'https:') return;
                if (url.hostname === host) return;

                a.target = '_blank';
                var rel = (a.rel || '').split(/\s+/).filter(Boolean);
                if (rel.indexOf('noopener') === -1) rel.push('noopener');
                if (rel.indexOf('noreferrer') === -1) rel.push('noreferrer');
                a.rel = rel.join(' ');
                a.dataset.extProcessed = '1';
            });
        }

        function boot() {
            mark();

            var scheduled = false;
            var observer = new MutationObserver(function () {
                if (scheduled) return;
                scheduled = true;
                requestAnimationFrame(function () {
                    scheduled = false;
                    mark();
                });
            });
            observer.observe(document.body, { childList: true, subtree: true });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot);
        } else {
            boot();
        }
    })();
</script>
