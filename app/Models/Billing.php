<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    protected $fillable = [
        'vps_id',  
        'cost',     
        'hour',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    public function vps()
    {
        return $this->belongsTo(VPS::class);
    }
}
