<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;

class ApiCategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return $this->apiResponse(CategoryResource::collection($category), 'return all categories', 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Category::create([
            'name' => $request->name,
        ]);
        return $this->apiResponse($data, 'category store successfully!', 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Category::where('id', $id)->update([
            'name' => $request->name,
        ]);
        return $this->apiResponse($data, 'Category updated successfully!', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->apiResponse(null, 'Category deleted successfully!', 401);
    }
}
