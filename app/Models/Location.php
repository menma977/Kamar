<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * @package App\Models
 * @property integer id
 * @property string address
 */
class Location extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'address',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  public function User() {
    return $this->belongsTo(User::class, "location");
  }

  public function Room() {
    return $this->belongsTo(Room::class, "location");
  }
}
