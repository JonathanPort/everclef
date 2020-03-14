<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class SocialCredential extends Model
{

    protected $dates = [
        "expires_at",
    ];

    protected $fillable = [
        "access_token",
        "avatar",
        "email",
        "expires_at",
        "name",
        "nickname",
        "provider_id",
        "provider_name",
        "refresh_token",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
