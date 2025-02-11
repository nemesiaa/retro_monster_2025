<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonsterType extends Model
{
    use HasFactory;

    protected $table = 'monster_types';

    protected $fillable = [
        'name',
        'created_at',
    ];

    public $timestamps = false;

    public function monsters()
    {
        return $this->hasMany(Monster::class, 'type_id');
    }
}
