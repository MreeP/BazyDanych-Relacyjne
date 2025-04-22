<x-customer::app-layout :header="__('My Posts')">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('My Posts') }}</h2>
            <a href="{{ route('customer.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Create Post') }}
            </a>
        </div>

        @if($posts->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('You haven\'t created any posts yet.') }}
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
                                    @if($post->published_at)
                                        {{ __('Published') }} {{ $post->published_at->diffForHumans() }}
                                    @else
                                        <span class="text-yellow-600">{{ __('Draft') }}</span>
                                    @endif
                                </p>
                            </div>
                            <p class="text-gray-700">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('customer.posts.show', $post) }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                    {{ __('View') }}
                                </a>
                                <a href="{{ route('customer.posts.edit', $post) }}" class="text-sm text-gray-600 hover:text-gray-500">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('customer.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
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
