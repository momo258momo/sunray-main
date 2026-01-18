<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    
    /**
     * Get the items for the order.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->select(['id', 'name', 'slug', 'image_url']);
    }

    public function review() {
    return $this->hasOne(Review::class);
}




}
