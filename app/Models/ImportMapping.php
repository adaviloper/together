<?php

namespace App\Models;

use App\Observers\ImportMappingObserver;
use App\Policies\ImportMappingPolicy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $subcategory_id
 * @property string $source
 * @property bool $skip
 *
 * @property Subcategory $subcategory
 */
#[ObservedBy([ImportMappingObserver::class])]
#[UsePolicy(ImportMappingPolicy::class)]
class ImportMapping extends Model
{
    /** @use HasFactory<\Database\Factories\ImportMappingFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'organization_id',
        'subcategory_id',
        'user_id',
        'source',
        'skip',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->orderBy('name');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
