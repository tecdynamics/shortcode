<?php

namespace Tec\Shortcode\Forms\Fields;

use Tec\Base\Forms\FormField;

class ShortcodeTabsField extends FormField
{
    protected function getTemplate(): string
    {
        return 'packages/shortcode::forms.fields.tabs';
    }

    public function getDefaults(): array
    {
        return [
            'fields' => [],
            'shortcode_attributes' => [],
            'max' => 20,
        ];
    }
}
