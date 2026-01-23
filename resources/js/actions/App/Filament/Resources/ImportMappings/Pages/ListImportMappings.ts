import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
const ListImportMappings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListImportMappings.url(options),
    method: 'get',
})

ListImportMappings.definition = {
    methods: ["get","head"],
    url: '/admin/import-mappings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
ListImportMappings.url = (options?: RouteQueryOptions) => {
    return ListImportMappings.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
ListImportMappings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListImportMappings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
ListImportMappings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListImportMappings.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
const ListImportMappingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListImportMappings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
ListImportMappingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListImportMappings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\ListImportMappings::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/ListImportMappings.php:7
* @route '/admin/import-mappings'
*/
ListImportMappingsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListImportMappings.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListImportMappings.form = ListImportMappingsForm

export default ListImportMappings