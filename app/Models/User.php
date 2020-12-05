<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property integer id
 * @property integer role
 * @property string name
 * @property string username
 * @property string password
 * @property integer location
 */
class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  protected $with = ['Location'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'role',
    'name',
    'username',
    'password',
    'location'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function Location()
  {
    return $this->hasOne(Location::class, "id", "location");
  }
}
