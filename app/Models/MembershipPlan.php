<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration_value',
        'duration_unit',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'duration_value' => 'integer',
            'price' => 'decimal:2',
        ];
    }
}
