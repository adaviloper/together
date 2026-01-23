import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
const ViewCategory = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewCategory.url(args, options),
    method: 'get',
})

ViewCategory.definition = {
    methods: ["get","head"],
    url: '/admin/categories/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
ViewCategory.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return ViewCategory.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
ViewCategory.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewCategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
ViewCategory.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewCategory.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
const ViewCategoryForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewCategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
ViewCategoryForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewCategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Categories\Pages\ViewCategory::__invoke
* @see app/Filament/Resources/Categories/Pages/ViewCategory.php:7
* @route '/admin/categories/{record}'
*/
ViewCategoryForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewCategory.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewCategory.form = ViewCategoryForm

export default ViewCategory