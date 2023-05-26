<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'average_pay_per_hour',
        'average_total_pay'
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
