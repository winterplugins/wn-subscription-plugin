<?php namespace Dimsog\Subscription\Models;

use Illuminate\Mail\Message;
use Mail;
use Illuminate\Support\Carbon;
use Cms\Classes\Page;
use Illuminate\Support\Facades\DB;
use Model;
use Winter\Storm\Support\Str;

/**
 * Email Model
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $verified_at
 * @property string $email
 * @property string $verify_code
 * @property string $unsubscribe_code
 * @property boolean $verified
 */
class Email extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dimsog_subscription_emails';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'verified' => 'boolean'
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'verified_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->bindEvent('model.beforeCreate', function () {
            $this->verify_code = Str::random(64);
            $this->unsubscribe_code = Str::random(64);

            $mailData = [
                'model' => $this,
                'confirmUrl' => Page::url('confirm-subscription', [
                    'code' => $this->verify_code
                ])
            ];
            Mail::sendTo($this->email, 'dimsog.subscription::mail.confirm_subscription', $mailData);
        });
    }

    public static function findByVerifyCode(string $code): ?static
    {
        return static::where('verify_code', $code)->first();
    }

    public static function findByUnsubscribeCode(string $code): ?static
    {
        return static::where('unsubscribe_code', $code)->first();
    }

    public static function findSubscribedEmails(): array
    {
        return static::where('verified', 1)
            ->orderBy('id')
            ->pluck('email')
            ->toArray();
    }

    public function subscribe(): bool
    {
        $this->verified_at = Carbon::now();
        $this->verified = true;
        return $this->save();
    }
}
