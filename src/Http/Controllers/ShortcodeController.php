<?php

namespace Tec\Shortcode\Http\Controllers;

use Tec\Base\Facades\Html;
use Tec\Base\Forms\FormAbstract;
use Tec\Base\Http\Controllers\BaseController;
use Tec\Shortcode\Events\ShortcodeAdminConfigRendering;
use Tec\Shortcode\Facades\Shortcode;
use Tec\Shortcode\Http\Requests\GetShortcodeDataRequest;
use Tec\Shortcode\Http\Requests\RenderBlockUiRequest;
use Closure;
use Illuminate\Support\Arr;

class ShortcodeController extends BaseController
{
    public function ajaxGetAdminConfig(?string $key, GetShortcodeDataRequest $request)
    {
        ShortcodeAdminConfigRendering::dispatch();

        $registered = shortcode()->getAll();

        $key = $key ?: $request->input('key');

        $data = Arr::get($registered, $key . '.admin_config');

        $attributes = [];
        $content = null;

        if ($code = $request->input('code')) {
            $compiler = shortcode()->getCompiler();
            $attributes = $compiler->getAttributes(html_entity_decode($code));
            $content = $compiler->getContent();
        }

        if ($data instanceof Closure || is_callable($data)) {
            $data = call_user_func($data, $attributes, $content);

            if ($modifier = Arr::get($registered, $key . '.admin_config_modifier')) {
                $data = call_user_func($modifier, $data, $attributes, $content);
            }

            $data = $data instanceof FormAbstract ? $data->renderForm() : $data;
        }

        $data = apply_filters(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, $data, $key, $attributes);

        if (! $data) {
            $data = Html::tag('code', Shortcode::generateShortcode($key, $attributes))->toHtml();
        }

        return $this
            ->httpResponse()
            ->setData($data);
    }

    public function ajaxRenderUiBlock(RenderBlockUiRequest $request)
    {
        $name = $request->input('name');

        if (! in_array($name, array_keys(Shortcode::getAll()))) {
            return $this
                ->httpResponse()
                ->setData(null);
        }

        $code = Shortcode::generateShortcode($name, $request->input('attributes', []));

        $content = Shortcode::compile($code, true)->toHtml();

        return $this
            ->httpResponse()
            ->setData($content);
    }
}
