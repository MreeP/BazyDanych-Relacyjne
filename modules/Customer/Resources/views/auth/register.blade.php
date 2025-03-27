<x-customer::auth-layout :header="__('Sign in to your account')">
    <x-slot:description>
        <x-texts.links.primary :text="__('Already have an account?')" :href="\Illuminate\Support\Facades\URL::route('guest.auth.customer.login')" class="text-sm" />
    </x-slot:description>

    <form action="{{ \Illuminate\Support\Facades\URL::route('guest.auth.customer.register') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.inputs.input name="name" :label="__('Name')" />

        <x-form.inputs.input type="email" name="email" :label="__('Email')" />

        <x-form.inputs.input type="password" name="password" :label="__('Password')" />

        <x-form.inputs.input type="password" name="password_confirmation" :label="__('Confirm password')" />

        <x-buttons.primary :text="__('Sign up')" class="w-full" />
    </form>
</x-customer::auth-layout>
