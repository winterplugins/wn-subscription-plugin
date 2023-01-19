<?php

declare(strict_types=1);

namespace Dimsog\Subscription\Components;

use Mail;
use Cms\Classes\ComponentBase;
use Dimsog\Subscription\Models\Email;
use Winter\Storm\Exception\ValidationException;
use Winter\Storm\Support\Facades\Validator;

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
            'email' => 'required|email|min:2|max:64'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // check user is subscribed
        $model = Email::findByEmail(post('email'));
        if ($model !== null && $model->verified) {
            throw new ValidationException([
                'email' => __('dimsog.subscription::lang.components.subscribeForm.already_subscribed')
            ]);
        }

        if ($model === null) {
            $model = new Email();
            $model->email = post('email');
            $model->save();
        } else {
            // throttle
            if ($model->needWaiting()) {
                throw new ValidationException([
                    'email' => sprintf(__('dimsog.subscription::lang.components.subscribeForm.need_waiting'), 5)
                ]);
            }
            $model->sendVerificationCode();
        }

        return [
            '#' . $this->alias . '-form' => $this->renderPartial('@success')
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }
}
