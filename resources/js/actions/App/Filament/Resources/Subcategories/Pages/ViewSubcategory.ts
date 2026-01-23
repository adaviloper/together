import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
const ViewSubcategory = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewSubcategory.url(args, options),
    method: 'get',
})

ViewSubcategory.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
ViewSubcategory.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewSubcategory.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
ViewSubcategory.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
ViewSubcategory.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewSubcategory.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
const ViewSubcategoryForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
ViewSubcategoryForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
ViewSubcategoryForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewSubcategory.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewSubcategory.form = ViewSubcategoryForm

export default ViewSubcategory