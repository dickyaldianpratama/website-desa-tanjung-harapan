<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Visitor;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
     
    }

    
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view) {
            $today = Carbon::today()->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();
            $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
            $endOfWeek = Carbon::now()->endOfWeek()->toDateString();
            $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek()->toDateString();
            $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek()->toDateString();
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

            $visitorStats = [
                'today' => Visitor::where('visit_date', $today)->count(),
                'yesterday' => Visitor::where('visit_date', $yesterday)->count(),
                'this_week' => Visitor::whereBetween('visit_date', [$startOfWeek, $endOfWeek])->count(),
                'last_week' => Visitor::whereBetween('visit_date', [$startOfLastWeek, $endOfLastWeek])->count(),
                'this_month' => Visitor::whereBetween('visit_date', [$startOfMonth, $endOfMonth])->count(),
                'last_month' => Visitor::whereBetween('visit_date', [$startOfLastMonth, $endOfLastMonth])->count(),
                'total' => Visitor::count(),
            ];

            $view->with('visitorStats', $visitorStats);
        });
    }
}
