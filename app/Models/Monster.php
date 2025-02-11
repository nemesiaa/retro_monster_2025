<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    use HasFactory;

    protected $table = 'monsters';

    protected $fillable = [
        'name',
        'user_id',
        'type_id',
        'pv',
        'attack',
        'image_url',
        'description',
        'defense',
        'rarety_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function type()
    {
        return $this->belongsTo(MonsterType::class, 'type_id');
    }

    public function rarety()
    {
        return $this->belongsTo(Rarety::class, 'rarety_id');
    }
}
