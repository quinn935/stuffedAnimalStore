<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'price', 'image', 'created_by', 'updated_by', 'category_id', 'length', 'width', 'depth', 'sitting_height', 'hard_eyes', 'main_material', 'inner_filling_material'];
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
       return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    //The images method does not directly return a collection of ProductImage instances.
    // Instead, it returns an Eloquent relationship query builder
    public function images():HasMany{
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    //This method defines a custom attribute called image for the Product model.
    //In Laravel, to define an accessor, you use the getAttribute suffix in the method name,
    //$this->image from ProductListResource
    public function getMainImageAttribute(){
        return $this->images->count()>0? $this->images->get(0)->url : null;
    }

    public function getSecondImageAttribute(){
        return $this->images->count()>0? $this->images->get(1)->url : null;
    }

    public function category() : BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function reviews() : HasMany{
        return $this->hasMany(ProductReview::class);
    }

    public function getProductAverageReviewAttribute(){

        return $this->reviews->count()? round($this->reviews->sum('rating')/$this->reviews->count(), 1) : 0;
    }

}
