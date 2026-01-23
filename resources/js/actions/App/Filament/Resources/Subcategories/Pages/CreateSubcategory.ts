import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
const CreateSubcategory = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSubcategory.url(options),
    method: 'get',
})

CreateSubcategory.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
CreateSubcategory.url = (options?: RouteQueryOptions) => {
    return CreateSubcategory.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
CreateSubcategory.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSubcategory.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
CreateSubcategory.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateSubcategory.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
const CreateSubcategoryForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSubcategory.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
CreateSubcategoryForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSubcategory.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
CreateSubcategoryForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSubcategory.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateSubcategory.form = CreateSubcategoryForm

export default CreateSubcategory