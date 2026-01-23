import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
const CreateImportMapping = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateImportMapping.url(options),
    method: 'get',
})

CreateImportMapping.definition = {
    methods: ["get","head"],
    url: '/admin/import-mappings/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
CreateImportMapping.url = (options?: RouteQueryOptions) => {
    return CreateImportMapping.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
CreateImportMapping.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateImportMapping.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
CreateImportMapping.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateImportMapping.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
const CreateImportMappingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateImportMapping.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
CreateImportMappingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateImportMapping.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\CreateImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/CreateImportMapping.php:7
* @route '/admin/import-mappings/create'
*/
CreateImportMappingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateImportMapping.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateImportMapping.form = CreateImportMappingForm

export default CreateImportMapping