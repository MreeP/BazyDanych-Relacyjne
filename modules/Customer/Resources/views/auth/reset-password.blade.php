<x-customer::auth-layout :header="__('Reset password')">
    <form action="{{ \Illuminate\Support\Facades\URL::route('guest.auth.customer.password.update') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.inputs.hidden-input name="token" :value="$token" />

        <x-form.inputs.input type="email" name="email" :label="__('Email')" :value="\Illuminate\Support\Facades\Request::old('email', $email)" />

        <x-form.inputs.input type="password" name="password" :label="__('Password')" />

        <x-form.inputs.input type="password" name="password_confirmation" :label="__('Confirm password')" />

        <x-buttons.primary :text="__('Reset')" class="w-full" />
    </form>
</x-customer::auth-layout>
