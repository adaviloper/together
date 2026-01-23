<div class="overflow-x-auto">
    <div class="mb-4">
        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
        <select
            wire:model.live="year"
            id="year"
            class="mt-1 block w-32 rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
        >
            @foreach ($this->getYearOptions() as $yearOption)
                <option value="{{ $yearOption }}">{{ $yearOption }}</option>
            @endforeach
        </select>
    </div>

    <table class="min-w-full border border-gray-300 dark:border-gray-600">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th scope="col" class="sticky left-0 z-10 bg-gray-100 dark:bg-gray-800 px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider min-w-[280px] border-b border-r border-gray-300 dark:border-gray-600">
                    Description
                </th>
                @foreach ($months as $monthNum => $monthName)
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider min-w-[100px] border-b border-r border-gray-300 dark:border-gray-600 last:border-r-0">
                        {{ $monthName }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900">
            @foreach ($this->getRowOrder() as $row)
                @php
                    $rowKey = $row['key'];
                    $rowType = $row['type'];
                    $indent = $row['indent'];

                    $isIncome = str_ends_with($rowKey, ' Income');
                    $isUserExpected = str_contains($rowKey, 'Expected Total');
                    $isUserPaid = str_contains($rowKey, 'Already Paid');
                    $isOverage = str_contains($rowKey, 'Overage/Owed');
                    $isPaidReceived = str_contains($rowKey, 'Paid/Received');
                    $isCategoryTotal = str_starts_with($rowKey, 'Total ');
                    $isValidated = $rowKey === 'Validated?';
                    $isTotalExpenditure = $rowKey === 'Total Expenditures';
                    $isPercentageSlice = str_contains($rowKey, 'Percentage Slice');
                    $isContribution = str_contains($rowKey, 'Contribution');
                    $isSlice = str_contains($rowKey, 'Slice') && !$isPercentageSlice;

                    // Use fully opaque backgrounds so sticky column doesn't show content behind it
                    $rowBgClass = 'bg-white dark:bg-gray-900';
                    if ($isIncome) {
                        $rowBgClass = 'bg-green-50 dark:bg-green-950';
                    } elseif ($isUserExpected || $isUserPaid) {
                        $rowBgClass = 'bg-blue-50 dark:bg-blue-950';
                    } elseif ($isOverage || $isPaidReceived) {
                        $rowBgClass = 'bg-amber-50 dark:bg-amber-950';
                    } elseif ($isTotalExpenditure) {
                        $rowBgClass = 'bg-gray-100 dark:bg-gray-800';
                    } elseif ($isPercentageSlice) {
                        $rowBgClass = 'bg-purple-50 dark:bg-purple-950';
                    } elseif ($isContribution || $isSlice) {
                        $rowBgClass = 'bg-red-100 dark:bg-red-900';
                    }

                    $fontClass = ($isTotalExpenditure || $isPercentageSlice) ? 'font-semibold' : 'font-medium';
                    $paddingClass = $indent > 0 ? 'pl-8' : 'pl-4';
                @endphp
                <tr class="{{ $rowBgClass }}">
                    <td class="sticky left-0 z-10 {{ $rowBgClass }} {{ $paddingClass }} pr-4 py-2 whitespace-nowrap text-sm {{ $fontClass }} text-gray-900 dark:text-gray-100 border-b border-r border-gray-200 dark:border-gray-700">
                        {{ $rowKey }}
                    </td>
                    @foreach ($months as $monthNum => $monthName)
                        @php
                            $value = $breakdownData[$rowKey][$monthNum] ?? null;
                        @endphp
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right text-gray-700 dark:text-gray-300 border-b border-r border-gray-200 dark:border-gray-700 last:border-r-0">
                            {{ $this->formatValue($value, $rowType) }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
