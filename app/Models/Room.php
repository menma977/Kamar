<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Room
 * @package App\Models
 * @property integer id
 * @property string name
 * @property integer price
 * @property boolean is_bond
 * @property boolean is_man
 * @property string renter
 * @property string join
 * @property string end
 * @property integer item
 * @property integer location
 */
class Room extends Model
{
  use HasFactory,Notifiable;

  protected $with = ['Location'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'price',
    'image',
    'is_bond',
    'is_man',
    'renter',
    'join',
    'end',
    'item',
    'location',
    'payment'
  ];

  protected $hidden = [
    'id',
    'created_at',
    'updated_at',

  ];

  public function Location()
  {
    return $this->hasOne(Location::class, 'id','location');
  }

}
