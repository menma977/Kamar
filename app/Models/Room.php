<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 * @package App\Models
 * @property integer id
 * @property string name
 * @property integer price
 * @property boolean is_bond
 * @property boolean is_man
 * @property string join
 * @property string end
 * @property integer item
 * @property integer location
 */
class Room extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'price',
    'is_bond',
    'is_man',
    'join',
    'end',
    'item',
    'location',
  ];

  protected $hidden = [
    'id',
    'created_at',
    'updated_at'
  ];

  public function location()
  {
    return $this->belongsTo(Location::class, 'id');
  }
}
