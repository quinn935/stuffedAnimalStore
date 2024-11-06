<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\ProductListResource;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search', false);
        $per_page = request('per_page', 10);
        $sort_field = request('sort_field', 'updated_at');
        $sort_direction = request('sort_direction', 'desc');

        $query = Product::query()->orderBy($sort_field, $sort_direction);

        if($search){
            $query->where('title', 'like', '%{$search}%')
                ->orWhere('description', 'like', '%{$search}%');
        }

        return ProductListResource::collection($query->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images']??[];
        $product = Product::create($data);
        if(count($images)>0){
            $id = $product->id;
            $paths = $this->saveImages($images, $id);
        }
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images']??[];
        $deletedImages = $data['deleted_images']??[];
        if(count($images)>0){
            $id = $product->id;
            $this->saveImages($images, $id);
        }
        if(count($deletedImages)>0){
            $this->deleteImages($deletedImages, $product);
        }
        $product->update($data);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }


    private function saveImages($images, $id){
        foreach ($images as $i => $image) {
            $path = 'images/' . $id;

            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0755, true);
            }
            if (!Storage::disk('public')->putFileAs($path, $image, $image->getClientOriginalName())) {
                throw new \Exception("Unable to save the file " . $image->getClientOriginalName());
            }
            $relativePath = $path . '/' . $image->getClientOriginalName();

            ProductImage::create([
                'product_id' => $id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $i+1
            ]);
        }
        return $path . '/' . $image->getClientOriginalName();
    }

    private function deleteImages($imageIds, Product $product){
        //SELECT * FROM product_images WHERE product_id = ? AND id IN (?, ?, ?, ...);
        $images = ProductImage::query()
                ->where('product_id', $product->id)
                ->whereIn('id', $imageIds)
                ->get();

        foreach($images as $image){
            if($image->path){
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }
    }


}
