<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'status',
        'client_id',
    ];

    public function client() 
    {
        return $this->belongsTo(Client::class);
    }
    public function products()
    {
        return $this->belongsToMany(Meeting::class, 'order_details')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
