<?php

namespace App\Models;

use App\Models\Scopes\CurrentOrgScope;
use App\Policies\TransactionPolicy;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $user_id
 * @property string $transaction_date
 * @property string $description
 * @property string $organization_id
 * @property string $category_id
 * @property string $subcategory_id
 * @property int $amount
 *
 * @method static TransactionFactory factory()
 */
#[ScopedBy(CurrentOrgScope::class)]
#[UsePolicy(TransactionPolicy::class)]
class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    use HasUuids;

    protected $fillable = [
        'organization_id',
        'category_id',
        'subcategory_id',
        'user_id',
        'transaction_date',
        'description',
        'amount',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->orderBy('name', 'asc');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class)->orderBy('name', 'asc');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->orderBy('name', 'asc');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->orderBy('name', 'asc');
    }
}
