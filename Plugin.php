<?php

declare(strict_types=1);

namespace Dimsog\Subscription;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name'        => 'dimsog.blocks::lang.plugin.name',
            'description' => 'dimsog.blocks::lang.plugin.description',
            'author'      => 'Dimsog',
            'icon'        => 'icon-file-text-o'
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'blocks' => [
                'label'       => 'dimsog.blocks::lang.plugin.name',
                'url'         => Backend::url('dimsog/blocks/blocks'),
                'icon'        => 'icon-file-text-o',
                'permissions' => ['*'],
                'order'       => 500,
                'sideMenu' => [
                    'blocks' => [
                        'label'       => 'dimsog.blocks::lang.plugin.name',
                        'icon'        => 'icon-file-text-o',
                        'url'         => Backend::url('dimsog/blocks/blocks'),
                    ],
                    'categories' => [
                        'label'       => 'dimsog.blocks::lang.models.category.label_plural',
                        'icon'        => 'icon-th-list',
                        'url'         => Backend::url('dimsog/blocks/categories'),
                    ]
                ]
            ]
        ];
    }
}
