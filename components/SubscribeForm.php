<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Components;

use Illuminate\Mail\Message;
use Mail;
use Backend\Facades\Backend;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Dimsog\Subscription\Models\Email;
use Winter\Storm\Exception\ValidationException;
use Winter\Storm\Mail\Mailable;
use Winter\Storm\Support\Facades\Validator;
use Winter\Storm\Support\Str;

class SubscribeForm extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name'        => 'SubscribeForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onSubscribe(): array
    {
        $validator = Validator::make(post(), [
            'email' => 'required|email|min:2|max:64|unique:dimsog_subscription_emails,email'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $model = new Email();
        $model->email = post('email');
        $model->save();

        return [
            '#' . $this->alias . '-form' => $this->renderPartial('@success')
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }
}
