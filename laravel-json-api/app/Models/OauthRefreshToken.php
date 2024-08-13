<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthRefreshToken extends Model
{
    use HasFactory;

    protected $table = 'oauth_refresh_tokens';

    protected $fillable = ['id', 'access_token_id', 'revoked', 'expires_at'];
public $timestamps = false;
protected $primaryKey = 'id';

}