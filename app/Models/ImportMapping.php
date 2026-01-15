<?php

namespace App\Models;

use App\Observers\ImportMappingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $subcategory_id
 * @property string $source
 *
 * @property Subcategory $subcategory
 */
#[ObservedBy([ImportMappingObserver::class])]
class ImportMapping extends Model
{
    /** @use HasFactory<\Database\Factories\ImportMappingFactory> */
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'source',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->orderBy('name');
    }
}
