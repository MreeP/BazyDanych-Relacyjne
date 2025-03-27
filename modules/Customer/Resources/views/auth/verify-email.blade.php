<x-customer::auth-layout :header="__('Verify your email address')" :description="__('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')">
    <div class="space-y-3">
        <form method="POST" action="{{ route('customer.auth.verification.send') }}">
            @csrf

            <div>
                <x-buttons.primary :text="__('Resend Verification Email')" class="w-full" />
            </div>
        </form>

        <form method="POST" action="{{ route('customer.auth.logout') }}">
            @csrf

            <div>
                <x-buttons.secondary :text="__('Log out')" class="w-full" />
            </div>
        </form>
    </div>
</x-customer::auth-layout>
