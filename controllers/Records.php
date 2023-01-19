<?php namespace Dimsog\Subscription\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Records Backend Controller
 */
class Records extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Dimsog.Subscription', 'subscription', 'records');
    }
}
