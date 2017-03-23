<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['access_token', 'refresh_token', 'expires_in'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
