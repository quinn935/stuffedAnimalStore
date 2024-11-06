<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::query()->orderBy('updated_at', 'desc')->paginate(8);
        return view('home.index', compact('products'));
    }

    public function viewProductsByCategory(Category $category){
        $parentCategory = $category->parent_id? Category::where('id', $category->parent_id)->first(): null;
        $products =  Product::where('category_id', $category->id)->get();
        return view('products.viewProductsByCategory', compact('products', 'category', 'parentCategory'));
    }

    public function viewSingleProduct(Product $product){
        return view('products.view', compact('product'));
    }

}
