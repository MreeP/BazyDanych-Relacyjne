<x-admin::app-layout :header="__('Post')">
    <div class="space-y-8">
        <!-- Post -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 space-y-6">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            {{ __('By') }} {{ $post->author->name }} ·
                            @if($post->published_at)
                                {{ $post->published_at->format('F j, Y') }}
                            @else
                                <span class="text-yellow-600">{{ __('Draft') }}</span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm text-gray-600 hover:text-gray-500">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none">
                    @markdown($post->content)
                </div>

                <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                    <span class="text-sm text-gray-500">
                        {{ $post->likes->count() }} {{ __('Likes') }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $post->comments->count() }} {{ __('Comments') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Comments') }}</h2>

            @if($post->comments->where('parent_id', null)->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500">
                        {{ __('No comments yet.') }}
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($post->comments->where('parent_id', null) as $comment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold">{{ $comment->author->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" class="text-sm text-gray-600 hover:text-gray-500 edit-comment" data-comment-id="{{ $comment->id }}">
                                            {{ __('Edit') }}
                                        </button>
                                        <form action="{{ route('admin.posts.comments.destroy', [$post, $comment]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="comment-content-{{ $comment->id }}">
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>

                                <div class="comment-edit-form-{{ $comment->id }} hidden">
                                    <form action="{{ route('admin.posts.comments.update', [$post, $comment]) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <x-form.inputs.textarea name="content" :label="__('')" :value="$comment->content" rows="3" required />
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" class="cancel-edit inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" data-comment-id="{{ $comment->id }}">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                {{ __('Update') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex items-center space-x-4 pt-2">
                                    <span class="text-sm text-gray-500">
                                        {{ $comment->likes->count() }} {{ __('Likes') }}
                                    </span>
                                </div>

                                <!-- Replies -->
                                @if($comment->replies->count() > 0)
                                    <div class="mt-4 pl-6 border-l-2 border-gray-200 space-y-4">
                                        @foreach($comment->replies as $reply)
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-semibold">{{ $reply->author->name }}</span>
                                                        <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <button type="button" class="text-sm text-gray-600 hover:text-gray-500 edit-comment" data-comment-id="{{ $reply->id }}">
                                                            {{ __('Edit') }}
                                                        </button>
                                                        <form action="{{ route('admin.posts.comments.destroy', [$post, $reply]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this reply?') }}')">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="comment-content-{{ $reply->id }}">
                                                    <p class="text-gray-700">{{ $reply->content }}</p>
                                                </div>

                                                <div class="comment-edit-form-{{ $reply->id }} hidden">
                                                    <form action="{{ route('admin.posts.comments.update', [$post, $reply]) }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        @method('PUT')
                                                        <div>
                                                            <x-form.inputs.textarea name="content" :label="__('')" :value="$reply->content" rows="2" required />
                                                        </div>
                                                        <div class="flex justify-end space-x-2">
                                                            <button type="button" class="cancel-edit inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" data-comment-id="{{ $reply->id }}">
                                                                {{ __('Cancel') }}
                                                            </button>
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                {{ __('Update') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <span class="text-sm text-gray-500">
                                                        {{ $reply->likes->count() }} {{ __('Likes') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Edit comment
            document.querySelectorAll('.edit-comment').forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const contentDiv = document.querySelector(`.comment-content-${commentId}`);
                    const editForm = document.querySelector(`.comment-edit-form-${commentId}`);

                    contentDiv.classList.add('hidden');
                    editForm.classList.remove('hidden');
                });
            });

            // Cancel edit
            document.querySelectorAll('.cancel-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const contentDiv = document.querySelector(`.comment-content-${commentId}`);
                    const editForm = document.querySelector(`.comment-edit-form-${commentId}`);

                    contentDiv.classList.remove('hidden');
                    editForm.classList.add('hidden');
                });
            });
        });
    </script>
</x-admin::app-layout>
