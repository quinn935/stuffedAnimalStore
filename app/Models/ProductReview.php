<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'rating', 'review_subject', 'review_comment', 'created_by', 'updated_by'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getProductReviewCountAttribute(){
        return $this->product->reviews->count();
    }


}
