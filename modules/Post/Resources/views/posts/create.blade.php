<x-customer::app-layout :header="__('Create Post')">
    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('customer.posts.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-form.inputs.input name="title" :label="__('Title')" :value="old('title')" required />
                    </div>

                    <div>
                        <x-form.inputs.textarea name="content" :label="__('Content')" :value="old('content')" rows="10" required />
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <button type="submit" name="publish" value="1" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Publish') }}
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Save as Draft') }}
                        </button>
                        <a href="{{ route('customer.posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer::app-layout>
