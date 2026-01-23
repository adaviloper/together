import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
const EditSubcategory = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSubcategory.url(args, options),
    method: 'get',
})

EditSubcategory.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
EditSubcategory.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditSubcategory.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
EditSubcategory.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
EditSubcategory.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditSubcategory.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
const EditSubcategoryForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
EditSubcategoryForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSubcategory.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
EditSubcategoryForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSubcategory.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditSubcategory.form = EditSubcategoryForm

export default EditSubcategory