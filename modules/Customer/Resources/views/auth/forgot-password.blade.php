<x-customer::auth-layout :header="__('Forgot your password?')" :description="__('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')">
    <form method="POST" action="{{ \Illuminate\Support\Facades\URL::route('guest.auth.customer.password.request') }}" class="space-y-6">
        @csrf

        <x-form.inputs.input :label="__('Email')" name="email" type="email" required />

        <x-buttons.primary :text="__('Email Password Reset Link')" class="w-full" />
    </form>
</x-customer::auth-layout>
