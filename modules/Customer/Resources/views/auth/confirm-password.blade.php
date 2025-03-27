<x-customer::auth-layout :header="__('Confirm password')" :description="__('This is a secure area of the application. Please confirm your password before continuing.')">
    <form method="POST" action="{{ route('customer.auth.password.confirm') }}" class="space-y-6">
        @csrf

        <x-form.inputs.input :label="__('Password')" name="password" type="password" required />

        <x-buttons.primary :text="__('Confirm')" class="w-full" />
    </form>
</x-customer::auth-layout>
