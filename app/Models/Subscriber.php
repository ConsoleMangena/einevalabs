<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\UniqueConstraintViolationException;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
    ];

    /**
     * `subscribers.email` carries a unique index, so two concurrent
     * subscribe requests for the same address can both miss the
     * firstOrCreate() lookup and race into a duplicate-key error. Catch it and
     * treat it as the success it actually is.
     */
    public static function subscribe(string $email): self
    {
        $email = mb_strtolower(trim($email));

        try {
            return static::firstOrCreate(['email' => $email]);
        } catch (UniqueConstraintViolationException) {
            return static::where('email', $email)->firstOrFail();
        }
    }
}
