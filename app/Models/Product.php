<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'name',
        'price',
        'description',
        'url_image',
        'category_id',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    // fucntion for seache : Laravel Scout package
    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        // $array = $this->toArray();

        // // Customize the data array...

        // return $array;

        // الحقول لبدك تبحث عن طريقها
        return [
            'name' => $this->name,
            'price' => $this->price,
        ];
    }

}
