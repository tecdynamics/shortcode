<?php

namespace Tec\Shortcode\Providers;

use Tec\Base\Facades\Assets;
use Tec\Base\Supports\ServiceProvider;
use Tec\Base\Traits\LoadAndPublishDataTrait;
use Tec\Shortcode\Compilers\ShortcodeCompiler;
use Tec\Shortcode\Shortcode;
use Tec\Shortcode\View\Factory;
use Illuminate\Support\Arr;

class ShortcodeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton('shortcode.compiler', ShortcodeCompiler::class);

        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });

        $this->app->singleton('view', function ($app) {
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new Factory($resolver, $finder, $app['events'], $app['shortcode.compiler']);
            $env->setContainer($app);
            $env->share('app', $app);

            return $env;
        });

        $this->app['blade.compiler']->directive('shortcode', function ($expression) {
            return do_shortcode($expression);
        });

        $this->app->instance('shortcode.modal.rendered', false);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('packages/shortcode')
            ->loadRoutes()
            ->loadHelpers()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->publishAssets();

        $this->app->booted(function () {

            add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS, function (string|null $buttons, array $attributes, string $id) {
                if (! $this->hasWithShortcode($attributes)) {
                    return $buttons;
                }

                $buttons = (string) $buttons;

                $buttons .= view('packages/shortcode::partials.shortcode-button', compact('id'))->render();

                return $buttons;
            }, 120, 3);

            add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS_HEADER, function (string|null $header, array $attributes) {
                if (! $this->hasWithShortcode($attributes)) {
                    return $header;
                }

                Assets::addStylesDirectly('vendor/core/packages/shortcode/css/shortcode.css');

                return $header;
            }, 120, 2);

            add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER, function (string|null $footer, array $attributes) {

                if (! $this->hasWithShortcode($attributes)) {
                    return $footer;
                }

                Assets::addScriptsDirectly('vendor/core/packages/shortcode/js/shortcode.js');

                $footer = (string) $footer;

                if (! $this->isShortcodeModalRendered()) {
                    $footer .= view('packages/shortcode::partials.shortcode-modal')->render();

                    $this->shortcodeModalRendered();
                }

                return $footer;
            }, 120, 2);
        });
    }

    protected function hasWithShortcode(array $attributes): bool
    {
        return (bool) Arr::get($attributes, 'with-short-code', false);
    }

    protected function isShortcodeModalRendered(): bool
    {
        return $this->app['shortcode.modal.rendered'] === true;
    }

    protected function shortcodeModalRendered(): void
    {
        $this->app->instance('shortcode.modal.rendered', true);
    }
}
