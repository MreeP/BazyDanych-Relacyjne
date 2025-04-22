<?php

namespace Modules\Admin\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Customer\Models\Customer;
use Modules\Post\Models\Comment;
use Modules\Post\Models\Like;
use Modules\Post\Models\Post;

/**
 * Class DashboardController
 *
 * controller for dashboard
 */
class DashboardController extends AdminController
{

    /**
     * Show the dashboard
     *
     * @return ViewContract
     */
    public function index(): ViewContract
    {
        // Get total counts
        $totalUsers = Customer::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();

        // Get new users in the last week
        $newUsers = Customer::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Get activity data for the last week
        $lastWeek = Carbon::now()->subDays(7);
        $activityData = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->copy()->addDays($i);
            $nextDay = $date->copy()->addDay();
            
            $activityData[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D'),
                'posts' => Post::whereBetween('created_at', [$date, $nextDay])->count(),
                'comments' => Comment::whereBetween('created_at', [$date, $nextDay])->count(),
                'likes' => Like::whereBetween('created_at', [$date, $nextDay])->count(),
            ];
        }

        return View::make('Admin::dashboard', compact(
            'totalUsers',
            'newUsers',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'activityData'
        ));
    }
}
