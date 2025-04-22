<x-customer::app-layout :header="__('Posts')">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('All Posts') }}</h2>
            <a href="{{ route('customer.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Create Post') }}
            </a>
        </div>

        @if($posts->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('No posts found.') }}
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('customer.posts.show', $post) }}" class="hover:text-indigo-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ __('By') }} {{ $post->author->name }} · {{ $post->published_at->diffForHumans() }}
                                </p>
                            </div>
                            <p class="text-gray-700">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('customer.posts.show', $post) }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                    {{ __('Read more') }}
                                </a>
                                <span class="text-sm text-gray-500">
                                    {{ $post->comments->count() }} {{ __('comments') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $post->likes->count() }} {{ __('likes') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-customer::app-layout>
