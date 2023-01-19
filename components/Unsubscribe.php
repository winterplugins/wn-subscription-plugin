<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Components;

use Cms\Classes\ComponentBase;
use Dimsog\Subscription\Models\Email;

class Unsubscribe extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name'        => 'UnSubscribe Component',
            'description' => ''
        ];
    }

    public function onRun()
    {
        $model = Email::findByUnsubscribeCode($this->property('code'));

        if ($model === null) {
            $this->controller->setStatusCode(404);
            return $this->controller->run('404');
        }
        $model->delete();
    }

    public function defineProperties(): array
    {
        return [
            'code' => [
                'type' => 'string',
                'title' => 'Code'
            ]
        ];
    }
}
