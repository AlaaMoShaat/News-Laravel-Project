<x-mail::message>
    # Introduction
    Thanks For Subscribe !!

    <x-mail::button :url="route('frontend.index')">
        Visit Our Website
    </x-mail::button>

    Thanks,
    {{ config('app.name') }}
</x-mail::message>