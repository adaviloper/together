import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/admin'
*/
dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dashboard.form = dashboardForm

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Dashboard::__invoke
* @see app/Filament/Pages/Dashboard.php:7
* @route '/admin/dashboard'
*/
dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dashboard.form = dashboardForm

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
export const breakdown = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: breakdown.url(options),
    method: 'get',
})

breakdown.definition = {
    methods: ["get","head"],
    url: '/admin/breakdown',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
breakdown.url = (options?: RouteQueryOptions) => {
    return breakdown.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
breakdown.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
breakdown.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: breakdown.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
const breakdownForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
breakdownForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: breakdown.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\Breakdown::__invoke
* @see app/Filament/Pages/Breakdown.php:7
* @route '/admin/breakdown'
*/
breakdownForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: breakdown.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

breakdown.form = breakdownForm

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
export const monthlyReview = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: monthlyReview.url(options),
    method: 'get',
})

monthlyReview.definition = {
    methods: ["get","head"],
    url: '/admin/monthly-review',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
monthlyReview.url = (options?: RouteQueryOptions) => {
    return monthlyReview.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
monthlyReview.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: monthlyReview.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
monthlyReview.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: monthlyReview.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
const monthlyReviewForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: monthlyReview.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
monthlyReviewForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: monthlyReview.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Pages\MonthlySummary::__invoke
* @see app/Filament/Pages/MonthlySummary.php:7
* @route '/admin/monthly-review'
*/
monthlyReviewForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: monthlyReview.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

monthlyReview.form = monthlyReviewForm

const pages = {
    dashboard: Object.assign(dashboard, dashboard),
    breakdown: Object.assign(breakdown, breakdown),
    monthlyReview: Object.assign(monthlyReview, monthlyReview),
}

export default pages