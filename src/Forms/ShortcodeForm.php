<?php

namespace Tec\Shortcode\Forms;

use Tec\Base\Forms\FormAbstract;
use Tec\Base\Models\BaseModel;
use Tec\Shortcode\Forms\Fields\ShortcodeTabsField;

class ShortcodeForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(BaseModel::class)
            ->contentOnly()
            ->addCustomField('tabs', ShortcodeTabsField::class);
    }

    public function renderForm(array $options = [], $showStart = false, $showFields = true, $showEnd = false): string
    {
        return parent::renderForm($options, $showStart, $showFields, $showEnd);
    }
}
