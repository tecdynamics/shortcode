<?php

namespace Tec\Shortcode\Http\Requests;

use Tec\Support\Http\Requests\Request;

class GetShortcodeDataRequest extends Request
{
    public function rules(): array
    {
        return [
            'key' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:1000000',
        ];
    }
}
