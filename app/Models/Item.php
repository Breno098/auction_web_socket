<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'initial_date',
        'final_date',
        'real_final_date',
        'initial_value',
        'bid_minimum_value',
        'description',
        'visible',
        'street',
        'district',
        'city',
        'state',
        'number',
        'brand',
        'model',
        'year',
        'color',
    ];

    protected $casts = [
        'initial_date' => 'datetime:Y-m-d H:i',
        'final_date' => 'datetime:Y-m-d H:i',
        'real_final_date' => 'datetime:Y-m-d H:i'
    ];

    protected $appends = [
        'atual_bid',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function getAtualBidAttribute()
    {
        return $this->bids()->orderBy('id', 'desc')->first();
    }

    public function latestBid()
    {
        return $this->hasOne(Bid::class)->latest();
    }
}
