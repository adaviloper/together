import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
const Breakdown = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Breakdown.url(options),
    method: 'get',
})

Breakdown.definition = {
    methods: ["get","head"],
    url: '/admin/breakdown',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
Breakdown.url = (options?: RouteQueryOptions) => {
    return Breakdown.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
Breakdown.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
Breakdown.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Breakdown.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
const BreakdownForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
BreakdownForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
BreakdownForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: Breakdown.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

Breakdown.form = BreakdownForm

export default Breakdown