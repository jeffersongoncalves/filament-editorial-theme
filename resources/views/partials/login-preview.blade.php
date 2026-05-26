@php
    $preview = config('filament-editorial-theme.login.preview_view');
    $previewData = config('filament-editorial-theme.login.preview_data', []);
    $bodyContent = null;

    if ($preview && view()->exists($preview)) {
        $rendered = view($preview, $previewData)->render();

        if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $rendered, $m)) {
            $bodyContent = $m[1];
        } else {
            $bodyContent = $rendered;
        }
    }
@endphp

<div x-ignore aria-hidden="true" inert class="login-preview-bg">
    @if ($bodyContent)
        {!! $bodyContent !!}
    @endif
</div>
