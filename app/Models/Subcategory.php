<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $category_id
 * @property string $name
 *
 * @property Category $category
 */
class Subcategory extends Model
{
    /** @use HasFactory<\Database\Factories\SubcategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'monthly_budgeted',
        'name',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->orderBy('name', 'asc');
    }
}
