<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->apiResponse(ProductResource::collection($products), 'return all products', 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'url_image' => $request->file('url_image')->store('image', 'public'),
            'category_id' => $request->category_id,
            'urls_image' => $request->urls_image,
        ]);
        if ($request->hasFile('urls_image')) {
            foreach ($request->file('urls_image') as $image) {
                $imagePath = $image->store('product_images', 'public');
                $data->images()->create(['url_image' => $imagePath]);
            }
        }
        return $this->apiResponse(ProductResource::make($data), 'Product store successfully!', 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oldProduct = Product::FindOrFail($id);
        if (Storage::exists($oldProduct->url_image) && $request->has('url_image')) {
            Storage::delete($oldProduct->url_image);
        }
        $data = Product::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'url_image' => $request->has('url_image') ? $request->file('url_image')->store('image', 'public') : $oldProduct->url_image,
            'category_id' => $request->category_id,
        ]);
        return $this->apiResponse(ProductResource::make($data), 'Product updated successfully!', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->images as $image) {
            Storage::disk('public', 'product_images')->delete($image->url_image);
        }
        $product->images()->delete();
        $product->delete();
        return $this->apiResponse(null, 'Product deleted successfully!', 401);
    }

    public function search(Request $request)
    {
        $data = Product::search($request->search)->get();
        if (!$data->isEmpty()) {
            return $this->apiResponse(ProductResource::collection($data), 'result of search by name', 401);
        }
        return $this->apiResponse(null, 'result not found', 401);
    }

    public function searchByMaxMinPrice(Request $request)
    {
        // dd($request->all());
        $minPrice = $request->min;
        $maxPrice = $request->max;
        // dd($minPrice,$maxPrice);
        $data = Product::whereBetween('price', [$minPrice, $maxPrice])->get();
        if (!$data->isEmpty()) {
            return $this->apiResponse(ProductResource::collection($data), 'result of search by price', 401);
        }
        return $this->apiResponse(null, 'result not found', 401);
    }

    public function returnProductHighestPrice(Request $request)
    {
        $topFiveProducts = Product::orderBy('price', 'desc')->take(5)->get();
        return $this->apiResponse(ProductResource::collection($topFiveProducts), 'result of search by price', 401);
    }
}
