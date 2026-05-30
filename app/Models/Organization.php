<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $name
 *
 * @property Collection $categories
 * @property Collection $importMappings
 * @property Collection $subcategories
 * @property Collection $users
 *
 * @method OrganizationFactory factory()
 */
class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'name',
    ];

    public function importMappings(): HasMany
    {
        return $this->hasMany(ImportMapping::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function subcategories(): HasManyThrough
    {
        return $this->hasManyThrough(Subcategory::class, Category::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
