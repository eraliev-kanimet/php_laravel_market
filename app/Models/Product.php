<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static paginate(int $int)
 * @method static where(string $string, mixed $input)
 * @method static find(int $int)
 * @property int $id
 * @property int $category_id
 * @property string $manufacturer
 * @property string $title
 * @property string $desc
 * @property int $count
 * @property int $price
 * @property array $images
 * @property array $properties
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'category_id',
        'desc',
        'manufacturer',
        'properties',
        'count',
        'price',
        'images'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'properties' => 'array',
        'images' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
