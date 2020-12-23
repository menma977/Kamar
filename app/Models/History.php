<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'roomId',
      'location',
      'join',
      'end'
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function Room()
  {
    return $this->hasMany(Room::class, 'id','roomId');
  }
}
