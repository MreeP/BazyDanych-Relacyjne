<x-admin::auth-layout :header="__('Sign in to your account')">
    <form action="{{ \Illuminate\Support\Facades\URL::route('guest.auth.admin.login') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.inputs.input name="email" :label="__('Email')" />

        <x-form.inputs.input type="password" name="password" :label="__('Password')" />

        <x-form.inputs.checkbox type="checkbox" name="remember-me" :label="__('Remember me')" class="flex flex-row-reverse items-center justify-end space-x-1 space-x-reverse" />

        <x-buttons.primary :text="__('Sign in')" class="w-full" />
    </form>
</x-admin::auth-layout>
