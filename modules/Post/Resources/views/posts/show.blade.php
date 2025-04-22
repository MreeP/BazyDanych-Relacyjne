<x-customer::app-layout :header="__('Post')">
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

                        @if(auth()->id() === $post->customer_id)
                            <div class="flex items-center space-x-2">
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
                            </div>
                        @endif
                    </div>
                </div>

                <div class="prose max-w-none">
                    @markdown($post->content)
                </div>

                <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                    <form action="{{ route('customer.posts.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-1 text-sm {{ $post->likes->where('customer_id', auth()->id())->count() ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                            <span>{{ $post->likes->count() }} {{ __('Likes') }}</span>
                        </button>
                    </form>
                    <span class="text-sm text-gray-500">
                        {{ $post->comments->count() }} {{ __('Comments') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Comments') }}</h2>

            <!-- Comment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('customer.posts.comments.store', $post) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-form.inputs.textarea name="content" :label="__('Add a comment')" :value="old('content')" rows="3" required />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Post Comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Comments List -->
            @if($post->comments->where('parent_id', null)->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500">
                        {{ __('No comments yet. Be the first to comment!') }}
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
                                        @if(auth()->id() === $comment->customer_id)
                                            <button type="button" class="text-sm text-gray-600 hover:text-gray-500 edit-comment" data-comment-id="{{ $comment->id }}">
                                                {{ __('Edit') }}
                                            </button>
                                            <form action="{{ route('customer.posts.comments.destroy', [$post, $comment]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @elseif(auth()->id() === $post->customer_id)
                                            <form action="{{ route('customer.posts.comments.destroy', [$post, $comment]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="comment-content-{{ $comment->id }}">
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>

                                <div class="comment-edit-form-{{ $comment->id }} hidden">
                                    <form action="{{ route('customer.posts.comments.update', [$post, $comment]) }}" method="POST" class="space-y-4">
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
                                    <form action="{{ route('customer.comments.like', [$post, $comment]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-1 text-sm {{ $comment->likes->where('customer_id', auth()->id())->count() ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                            </svg>
                                            <span>{{ $comment->likes->count() }}</span>
                                        </button>
                                    </form>
                                    <button type="button" class="text-sm text-gray-500 hover:text-gray-700 reply-toggle" data-comment-id="{{ $comment->id }}">
                                        {{ __('Reply') }}
                                    </button>
                                </div>

                                <!-- Reply Form -->
                                <div class="reply-form-{{ $comment->id }} hidden mt-4">
                                    <form action="{{ route('customer.posts.comments.reply', [$post, $comment]) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <x-form.inputs.textarea name="content" :label="__('Your reply')" rows="2" required />
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" class="cancel-reply inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" data-comment-id="{{ $comment->id }}">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                {{ __('Reply') }}
                                            </button>
                                        </div>
                                    </form>
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
                                                        @if(auth()->id() === $reply->customer_id)
                                                            <button type="button" class="text-sm text-gray-600 hover:text-gray-500 edit-comment" data-comment-id="{{ $reply->id }}">
                                                                {{ __('Edit') }}
                                                            </button>
                                                            <form action="{{ route('customer.posts.comments.destroy', [$post, $reply]) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this reply?') }}')">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @elseif(auth()->id() === $post->customer_id)
                                                            <form action="{{ route('customer.posts.comments.destroy', [$post, $reply]) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this reply?') }}')">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="comment-content-{{ $reply->id }}">
                                                    <p class="text-gray-700">{{ $reply->content }}</p>
                                                </div>

                                                <div class="comment-edit-form-{{ $reply->id }} hidden">
                                                    <form action="{{ route('customer.posts.comments.update', [$post, $reply]) }}" method="POST" class="space-y-4">
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
                                                    <form action="{{ route('customer.comments.like', [$post, $reply]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="flex items-center space-x-1 text-sm {{ $reply->likes->where('customer_id', auth()->id())->count() ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-500' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                            </svg>
                                                            <span>{{ $reply->likes->count() }}</span>
                                                        </button>
                                                    </form>
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
            // Reply toggle
            document.querySelectorAll('.reply-toggle').forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.querySelector(`.reply-form-${commentId}`);
                    replyForm.classList.toggle('hidden');
                });
            });

            // Cancel reply
            document.querySelectorAll('.cancel-reply').forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.getAttribute('data-comment-id');
                    const replyForm = document.querySelector(`.reply-form-${commentId}`);
                    replyForm.classList.add('hidden');
                });
            });

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
</x-customer::app-layout>
