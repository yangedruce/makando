@php
    $title = 'Profile';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        @include('dashboard.profile.partials.email-verification')
    @endif
    @include('dashboard.profile.partials.profile-form')

    @if($user->isCustomer())
        @include('dashboard.profile.partials.customer-form')
    @endif
    
    @include('dashboard.profile.partials.password-form')
    @include('dashboard.profile.partials.delete-form')

</x-layouts.dashboard>
