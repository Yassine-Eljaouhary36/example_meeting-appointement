<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
        'DateMeeting',
        'status',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->ref = '#'.Str::random(6). date('YmdHi');
        });
    }
}
