<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const NUMBER_PATTERN = 'CC-%s-SL';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'first_name', 'second_name', 'last_name', 'phone', 'email'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($post)
        {
            $lastId = (Contact::count() > 0) ?
                Contact::orderBy('created_at', 'desc')->first()->id + 1 : 0;
            $lastIdWithLeftPadding = str_pad($lastId, 6, '0', STR_PAD_LEFT);

            $post->number = sprintf(self::NUMBER_PATTERN, $lastIdWithLeftPadding);
        });
    }
}