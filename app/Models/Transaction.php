<?php

namespace App\Models;

use App\Policies\TransactionPolicy;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static TransactionFactory factory()
 */
#[UsePolicy(TransactionPolicy::class)]
class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'user_id',
        'transaction_date',
        'description',
        'amount',
        'hidden',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->orderBy('name', 'asc');
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
