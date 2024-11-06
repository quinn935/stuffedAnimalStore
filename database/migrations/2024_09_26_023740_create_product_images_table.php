<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('path', 255);
            $table->string('url', 255);
            $table->string('mime', 55);
            $table->integer('size');
            $table->integer('position');
            $table->timestamps();
        });

        DB::table('products')
            ->chunkById(100, function(Collection $products){
                $products = $products->filter(fn($p)=>(bool)$p->image)->map(function($p){
                    return [
                        'product_id' => $p->id,
                        'path'=>'',
                        'url'=>$p->image,
                        'mime'=>'',
                        'size'=>100,
                        'position'=>1,
                        'created_at'=>\Carbon\Carbon::now(),
                        'updated_at'=>\Carbon\Carbon::now()
                    ];
                });

                DB::table('product_images')->insert($products->all());
            });

            Schema::table('products', function(Blueprint $table){
                $table->dropColumn('image');
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function(Blueprint $table){
            $table->string('image')->nullable()->after('slug');
        });

        DB::table('products')
            ->chunkById(100, function(Collection $products){
                foreach($products as $product){
                    $image = DB::table('product_images')
                                ->select(['url'])
                                ->where('product_id', $product->id )
                                ->first();

                    DB::table('products')
                        ->where('id', $product->id)
                        ->update([
                            'image'=>$image->url,
                        ]);
                }
            });
    }
};
