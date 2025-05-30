<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPS extends Model
{
    use HasFactory;
    protected $table = 'vps';
    protected $fillable = [
        'user_id',
        'cpu',
        'ram',
        'storage',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}
