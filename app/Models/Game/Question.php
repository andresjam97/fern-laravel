<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'level',
    ];

    protected function score(): Attribute
    {
        return Attribute::make(
            get: fn() => match($this->level) {
                1 => 1000,
                2 => 1500,
                3 => 2000,
            },
        );
    }
}
