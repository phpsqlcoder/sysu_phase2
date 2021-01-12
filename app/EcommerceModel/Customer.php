<?php

namespace App\EcommerceModel;

use App\Notifications\Ecommerce\CustomerResetPasswordNotification;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'customers';
    protected $fillable = ['user_id', 'first_name', 'middle_name', 'last_name', 'ext_name', 'is_email_subscriber', 'organization', 'address_1', 'address_2', 'city', 'province', 'postal_code', 'country', 'contact_numbers', 'email', 'class', 'status', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setIsEmailSubscriberAttribute($value)
    {
        if ($value == 0 || $value == false) {
            $this->attributes['is_email_subscriber'] = 0;
        } else {
            $this->attributes['is_email_subscriber'] = 1;
        }
    }

    public function getContactNumbersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getIsActiveAttribute()
    {
        return $this->status == "active";
    }

    public function setContactNumbersAttribute($arrayValue)
    {
        $newValue = [];
        foreach ($arrayValue as $value) {
            if (!empty($value)) {
                array_push($newValue, $value);
            }
        }

        $this->attributes['contact_numbers'] = json_encode($newValue);
    }

    public function send_reset_password_email()
    {
        $token = app('auth.password.broker')->createToken($this->user);

        $this->notify(new CustomerResetPasswordNotification($token));
    }

    public function middle_name_abbreviation()
    {
        if (empty($this->middle_name)) {
            return ' ';
        }

        $explodeMN = explode(" ", $this->middle_name);

        $abbreviation = ' ';
        foreach($explodeMN as $mname) {
            $abbreviation .= strtoupper($mname[0]).'.';
        }

        return $abbreviation." ";
    }

    public function getFullNameWithAbbreviationAttribute() {
        return "{$this->first_name}{$this->middle_name_abbreviation()}{$this->last_name} {$this->ext_name}";
    }

    public function getFullNameAttribute() {
        if (empty($this->middle_name)) {
            return "{$this->first_name} {$this->last_name} {$this->ext_name}";
        }

        return "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->ext_name}";
    }

    public function getContactNumbersStrAttribute() {
        return implode(' / ', $this->contact_numbers);
    }

    public function is_an_email_subscriber()
    {
        return $this->is_email_subscriber == 1;
    }

}
