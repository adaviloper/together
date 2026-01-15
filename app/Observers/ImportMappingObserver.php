<?php

namespace App\Observers;

use App\Models\ImportMapping;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ImportMappingObserver
{
    /**
     * Handle the ImportMapping "created" event.
     */
    public function created(ImportMapping $importMapping): void
    {
        //
    }

    /**
     * Handle the ImportMapping "updated" event.
     */
    public function updated(ImportMapping $importMapping): void
    {
        $userIds = User::query()->where([
            'organization_id' => auth()->user()->organization_id,
        ])->get()->pluck('id');
        $subcategory = $importMapping->subcategory;
        Log::info($subcategory);
        Transaction::query()->whereIn('user_id', $userIds)
            ->where([
                'description' => $importMapping->source,
            ])
            ->update([
                'category_id' => $subcategory->category_id,
                'subcategory_id' => $subcategory->id,
            ]);
    }

    /**
     * Handle the ImportMapping "deleted" event.
     */
    public function deleted(ImportMapping $importMapping): void
    {
        //
    }

    /**
     * Handle the ImportMapping "restored" event.
     */
    public function restored(ImportMapping $importMapping): void
    {
        //
    }

    /**
     * Handle the ImportMapping "force deleted" event.
     */
    public function forceDeleted(ImportMapping $importMapping): void
    {
        //
    }
}
