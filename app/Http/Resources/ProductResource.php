<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'url_image' => $this->url_image,
            // هون بترجع كل الكاتيغوري تبع البرودكت
            'category_id' => CategoryResource::make($this->category),
            // 'urls_image' => $this->images,
        ];
    }
}
