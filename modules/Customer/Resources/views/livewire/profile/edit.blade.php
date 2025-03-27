<div class="space-y-12">
    <x-form.section :title="__('Basic information')" :description="__('Edit your profile details')">
        <x-form.form wire:submit.prevent="saveBasic">
            <x-slot name="actions">
                <x-buttons.primary :text="__('Save')" />
            </x-slot>

            <x-grids.cols-2 class="col-span-6">
                <x-form.inputs.input wire:model="basic.name" :label="__('Name')" class="col-span-2 xl:col-span-1" />
            </x-grids.cols-2>
        </x-form.form>
    </x-form.section>
    <x-form.section :title="__('Password')" :description="__('Change your profile password')">
        <x-form.form wire:submit.prevent="savePassword">
            <x-slot name="actions">
                <x-buttons.primary :text="__('Save')" />
            </x-slot>

            <x-grids.cols-2 class="col-span-6">
                <x-form.inputs.input type="password" wire:model="password.current_password" :label="__('Current password')" class="col-span-2 xl:col-span-1" />
            </x-grids.cols-2>
            <x-grids.cols-2 class="col-span-6">
                <x-form.inputs.input type="password" wire:model="password.password" :label="__('New password')" class="col-span-2 xl:col-span-1" />
            </x-grids.cols-2>
            <x-grids.cols-2 class="col-span-6">
                <x-form.inputs.input type="password" wire:model="password.password_confirmation" :label="__('Confirm new password')" class="col-span-2 xl:col-span-1" />
            </x-grids.cols-2>
        </x-form.form>
    </x-form.section>
</div>
