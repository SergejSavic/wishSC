<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WishUser
 *
 * @property int id
 * @property string context
 * @property string accessToken
 * @property string refreshToken
 * @property string accessTokenExpiration
 *
 * @method static Builder where($key, $value)
 * @method static WishUser first()
 *
 * @package App\Models
 */
class WishUser extends Model
{
    public $timestamps = false;
}

