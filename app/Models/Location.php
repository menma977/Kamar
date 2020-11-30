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
    'address',
  ];

  public function user() {
    return $this->belongsTo(User::class, "location");
  }

  public function room() {
    return $this->belongsTo(Room::class, "location");
  }
}
