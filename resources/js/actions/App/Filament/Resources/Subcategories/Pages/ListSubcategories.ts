import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
const ListSubcategories = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSubcategories.url(options),
    method: 'get',
})

ListSubcategories.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
ListSubcategories.url = (options?: RouteQueryOptions) => {
    return ListSubcategories.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
ListSubcategories.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSubcategories.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
ListSubcategories.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSubcategories.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
const ListSubcategoriesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSubcategories.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
ListSubcategoriesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSubcategories.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
ListSubcategoriesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSubcategories.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListSubcategories.form = ListSubcategoriesForm

export default ListSubcategories