<x-admin::auth-layout :header="__('Sign in to your account')">
    <form action="{{ \Illuminate\Support\Facades\URL::route('guest.auth.customer.login') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.inputs.input name="email" :label="__('Email')" />

        <x-form.inputs.input type="password" name="password" :label="__('Password')" />

        <div class="flex items-center justify-between">
            <x-form.inputs.checkbox type="checkbox" name="remember-me" :label="__('Remember me')" class="flex flex-row-reverse items-center space-x-1 space-x-reverse" />

            <div class="text-sm leading-6">
                <x-texts.links.primary :text="__('Forgot password?')" :href="\Illuminate\Support\Facades\URL::route('guest.auth.customer.password.request')" />
            </div>
        </div>

        <x-buttons.primary :text="__('Sign in')" class="w-full" />
    </form>
</x-admin::auth-layout>
