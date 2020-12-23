@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ env('MAIL_TEMPLATE_NAME', 'Dishrank Nu2') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ env('MAIL_TEMPLATE_NAME', 'Dishrank Nu2') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
