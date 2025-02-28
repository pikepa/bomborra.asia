<?php

declare(strict_types=1);

namespace App\Models;

use App\Mail\SubscribedEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

final class Subscriber extends Model
{
    use HasFactory, Notifiable;

    public $casts = [
        'validated_at' => 'datetime:format("yyyy-mm-dd")',
    ];

    protected $table = 'subscribers';

    protected $fillable = ['name', 'email', 'validation_key', 'validated_at'];

    public function OTP()
    {
        return Cache::get($this->OTPKey());
    }

    public function OTPKey()
    {
        return "OTP_for_{$this->id}";
    }

    public function cacheTheOTP()
    {
        $OTP = Str::random(32);

        $this->update(['validation_key' => $OTP]);

        Cache::put([$this->OTPKey() => $OTP], now()->addMinutes(30));

        return $OTP;
    }

    public function sendOTP()
    {
        //  $this->cacheTheOTP();

        Mail::to($this->email)
            ->queue(new SubscribedEmail($this->cacheTheOTP(), $this->id));
    }
}
