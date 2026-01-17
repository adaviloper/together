<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property int $monthly_budgeted
 *
 * @property Category $category
 * @property Subcategory $subcategory
 *
 * @mixin Illuminate\Database\Eloquent\Model
 */
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'monthly_budgeted',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('name', 'asc');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ?? 'Uncategorized',
        );
    }
}
