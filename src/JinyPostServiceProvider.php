<?php
namespace Jiny\Posts;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

use Illuminate\Routing\Router;

class JinyPostServiceProvider extends ServiceProvider
{
    private $package = "jiny-posts";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // 설정파일 복사
        $this->publishes([
            __DIR__.'/../config/setting.php' => config_path('jiny/posts/setting.php'),
        ]);


    }

    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            // Blog
            Livewire::component('site-post-list',
                \Jiny\Posts\Http\Livewire\SitePostList::class);
            Livewire::component('site-post-view',
                \Jiny\Posts\Http\Livewire\SitePostView::class);
            Livewire::component('site-post-comment',
                \Jiny\Posts\Http\Livewire\SitePostComment::class);
            Livewire::component('site-post-create',
                \Jiny\Posts\Http\Livewire\SitePostCreate::class);

        });

    }

}
