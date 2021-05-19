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

    // protected $appends = [
    //     'photos',
    // ];

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

    // public function getPhotosAttribute()
    // {
    //     return ['attr' => 'photos'];
    // }
}
