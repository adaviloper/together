<?php

namespace App\Observers;

use App\Models\ImportMapping;
use App\Models\Organization;
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
        $subcategory = $importMapping->subcategory;

        if (! $subcategory) {
            return;
        }

        Transaction::query()
            ->where([
                'description' => $importMapping->source,
                'organization_id' => session('current_organization_id'),
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
        Transaction::query()
            ->where([
                'description' => $importMapping->source,
                'organization_id' => session('current_organization_id'),
                'subcategory_id' => $importMapping->subcategory_id,
            ])
            ->update([
                'category_id' => null,
                'subcategory_id' => null,
            ]);
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
