<?php

namespace Modules\Post\Providers;

use App\Providers\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Post;
use Modules\Post\Policies\CommentPolicy;
use Modules\Post\Policies\PostPolicy;

/**
 * Class PostServiceProvider
 *
 * Service provider for the Post module
 */
class PostServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/post.php', 'post');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerMenuItems();

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Post');

        Blade::componentNamespace('Modules\\Post\\View\\Components', 'post');
    }

    /**
     * Register the module's policies.
     *
     * @return void
     */
    protected function registerPolicies(): void
    {
        $this->customerPolicy(Post::class, PostPolicy::class);
        $this->customerPolicy(Comment::class, CommentPolicy::class);
        
        // Register admin policies
        $this->policy(Post::class, \Modules\Post\Policies\Admin\PostPolicy::class, 'admin');
        $this->policy(Comment::class, \Modules\Post\Policies\Admin\CommentPolicy::class, 'admin');
    }

    /**
     * Register the module's menu items.
     *
     * @return void
     */
    protected function registerMenuItems(): void
    {
        $this->customerMenuEntry('customer.posts.index', 'Posts', 'heroicon-o-document-text', 'posts');
        $this->customerMenuEntry('customer.posts.my-posts', 'My Posts', 'heroicon-o-pencil-square', 'posts');
        $this->customerMenuEntry('customer.posts.create', 'Create Post', 'heroicon-o-plus', 'posts');
        
        // Admin menu entries
        $this->adminMenuEntry('admin.posts.index', 'Posts', 'heroicon-o-document-text', 'content');
    }
}
