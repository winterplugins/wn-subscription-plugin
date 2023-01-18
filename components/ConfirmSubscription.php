<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Components;

use Cms\Classes\ComponentBase;
use Dimsog\Subscription\Models\Email;

class ConfirmSubscription extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name'        => 'ConfirmSubscription Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun()
    {
        $model = Email::findBySubscribeCode((string) $this->property('code'));

        if ($model === null) {
            $this->controller->setStatusCode(404);
            return $this->controller->run('404');
        }

        $model->subscribe();
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
