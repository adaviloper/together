<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { update } from '@/routes/organization/current';
import type { Organization } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { Building2, Check, ChevronsUpDown } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const organizations = computed(() => page.props.auth.organizations as Organization[]);
const current = computed(() => page.props.auth.currentOrganization as Organization | null);

function switchOrganization(org: Organization) {
    if (org.id === current.value?.id) return;
    router.put(update.url(), { organization_id: org.id }, { preserveScroll: true });
}
</script>

<template>
    <DropdownMenu v-if="organizations.length > 0">
        <DropdownMenuTrigger as-child>
            <Button
                variant="outline"
                size="sm"
                class="flex items-center gap-2 text-sm"
            >
                <Building2 class="size-4 shrink-0 opacity-70" />
                <span class="max-w-36 truncate">{{ current?.name ?? 'Select organization' }}</span>
                <ChevronsUpDown class="size-3.5 shrink-0 opacity-50" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-56">
            <DropdownMenuLabel class="text-xs text-muted-foreground">Organizations</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem
                v-for="org in organizations"
                :key="org.id"
                class="cursor-pointer"
                @click="switchOrganization(org)"
            >
                <Check
                    class="mr-2 size-4"
                    :class="org.id === current?.id ? 'opacity-100' : 'opacity-0'"
                />
                {{ org.name }}
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
