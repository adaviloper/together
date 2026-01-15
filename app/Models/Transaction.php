<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_number',
        'category_id',
        'credit',
        'debit',
        'description',
        'posted_date',
        'subcategory_id',
        'transaction_date',
        'user_id',
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
