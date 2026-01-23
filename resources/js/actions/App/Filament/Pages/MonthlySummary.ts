import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
const MonthlySummary = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MonthlySummary.url(options),
    method: 'get',
})

MonthlySummary.definition = {
    methods: ["get","head"],
    url: '/admin/monthly-review',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
MonthlySummary.url = (options?: RouteQueryOptions) => {
    return MonthlySummary.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
MonthlySummary.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MonthlySummary.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
MonthlySummary.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: MonthlySummary.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
const MonthlySummaryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: MonthlySummary.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
MonthlySummaryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: MonthlySummary.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
MonthlySummaryForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: MonthlySummary.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

MonthlySummary.form = MonthlySummaryForm

export default MonthlySummary