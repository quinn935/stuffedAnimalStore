<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'rating' => $this->rating,
            'review_subject' => $this->review_subject,
            'review_comment' => $this->review_comment,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'product_reviews' => $this->product->reviews->map(fn($review)=>([
                'id' => $review->id,
                'subject' => $review->review_subject,
                'comment' => $review->review_comment,
                'rating' => $review->rating,
                'author' => $review->user->name,
                'updated_at' => $review->updated_at
            ])),
            'product_review_count'=> $this->getProductReviewCountAttribute(),
            'product_average_rating' => $this->product->getProductAverageReviewAttribute(),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s')
        ];
    }
}
