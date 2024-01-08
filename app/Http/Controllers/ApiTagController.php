<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponseTrait;

class ApiTagController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tag = Tag::all();
        return $this->apiResponse(TagResource::collection($tag), 'return all categories', 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Tag::create([
            'name' => $request->name,
        ]);
        return $this->apiResponse(TagResource::make($data), 'category store successfully!', 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Tag::where('id', $id)->update([
            'name' => $request->name,
        ]);
        return $this->apiResponse(TagResource::make($data), 'Category updated successfully!', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Tag::findOrFail($id);
        $category->delete();
        return $this->apiResponse(null, 'Category deleted successfully!', 401);
    }
}
