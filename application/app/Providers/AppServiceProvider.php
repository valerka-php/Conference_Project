<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Conference;
use App\Models\Export;
use App\Models\Report;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ConferencePolicy;
use App\Policies\ExportPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    protected $policies = [
        Conference::class => ConferencePolicy::class,
        Report::class => ReportPolicy::class,
        Comment::class => CommentPolicy::class,
        Category::class => CategoryPolicy::class,
        Export::class => ExportPolicy::class,
    ];

    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor/pagination/bootstrap-4');

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }
}
