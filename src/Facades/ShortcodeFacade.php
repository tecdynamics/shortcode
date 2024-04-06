<?php

namespace Tec\Shortcode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Tec\Shortcode\Shortcode register(string $key, string|null $name, string|null $description = null, $callback = null, string $previewImage = '')
 * @method static void remove(string $key)
 * @method static \Tec\Shortcode\Shortcode setPreviewImage(string $key, string $previewImage)
 * @method static \Tec\Shortcode\Shortcode enable()
 * @method static \Tec\Shortcode\Shortcode disable()
 * @method static \Illuminate\Support\HtmlString compile(string $value, bool $force = false)
 * @method static string|null strip(string|null $value)
 * @method static array getAll()
 * @method static void setAdminConfig(string $key, callable|array|string|null $html)
 * @method static void modifyAdminConfig(string $key, callable $callback)
 * @method static string generateShortcode(string $name, array $attributes = [])
 * @method static \Tec\Shortcode\Compilers\ShortcodeCompiler getCompiler()
 * @method static \Tec\Shortcode\ShortcodeField fields()
 *
 * @see \Tec\Shortcode\Shortcode
 * @deprecated
 */

class ShortcodeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'shortcode';
    }
}
