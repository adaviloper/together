@php
    $user = auth()->user();
    $organizations = $user ? $user->organization()->get(['organizations.id', 'organizations.name']) : collect();
    $currentOrganizationId = session('current_organization_id');
    $current = $currentOrganizationId ? $organizations->firstWhere('id', $currentOrganizationId) : null;
@endphp

@if ($organizations->count() > 1)
    <div
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
        class="relative flex items-center"
    >
        <button
            type="button"
            @click="open = !open"
            class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium ring-1 focus:outline-none {{ $current ? 'text-gray-700 ring-gray-300 hover:bg-gray-50 dark:text-gray-300 dark:ring-gray-600 dark:hover:bg-white/5' : 'text-gray-400 ring-gray-200 hover:bg-gray-50 dark:text-gray-500 dark:ring-gray-700 dark:hover:bg-white/5' }}"
        >
            <x-heroicon-o-building-office-2 class="h-4 w-4 {{ $current ? 'opacity-70' : 'opacity-40' }}" />
            <span class="max-w-36 truncate {{ $current ? '' : 'italic' }}">{{ $current?->name ?? 'Select organization' }}</span>
            <x-heroicon-o-chevron-up-down class="h-3.5 w-3.5 opacity-50" />
        </button>

        <div
            x-show="open"
            x-transition
            @click.outside="open = false"
            class="absolute left-0 top-full z-50 mt-1 w-56 origin-top-left rounded-lg bg-white shadow-lg ring-1 ring-black/5 focus:outline-none dark:bg-gray-800 dark:ring-white/10"
        >
            <p class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400">Organizations</p>
            <div class="border-t border-gray-100 dark:border-white/10"></div>
            @foreach ($organizations as $org)
                <form method="POST" action="{{ route('organization.current.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="organization_id" value="{{ $org->id }}">
                    <button
                        type="submit"
                        class="flex w-full items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5 {{ $org->id === $current?->id ? 'font-medium' : '' }}"
                    >
                        <x-heroicon-o-check class="h-4 w-4 {{ $org->id === $current?->id ? 'opacity-100' : 'opacity-0' }}" />
                        {{ $org->name }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>
@endif
