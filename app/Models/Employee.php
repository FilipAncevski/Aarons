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
    // public function shifts()
    // {
    //     return $this->hasMany(Shift::class, 'worker', 'full_name')
    //         ->where('company', $this->company)
    //         ->orderByDesc('date');
    // }

    // public function lastFivePayments()
    // {
    //     return $this->shifts()
    //         ->whereNotNull('paid_at')
    //         ->limit(5)
    //         ->get();
    // }
}
