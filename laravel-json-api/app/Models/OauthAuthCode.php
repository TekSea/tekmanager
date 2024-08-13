<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAuthCode extends Model
{
    use HasFactory;

    protected $table = 'oauth_auth_codes';

    protected $fillable = ['id', 'user_id', 'client_id', 'scopes', 'revoked', 'expires_at'];
public $timestamps = false;
protected $primaryKey = 'id';

}