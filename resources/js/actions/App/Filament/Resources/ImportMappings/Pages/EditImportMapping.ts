import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
const EditImportMapping = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditImportMapping.url(args, options),
    method: 'get',
})

EditImportMapping.definition = {
    methods: ["get","head"],
    url: '/admin/import-mappings/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
EditImportMapping.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditImportMapping.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
EditImportMapping.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditImportMapping.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
EditImportMapping.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditImportMapping.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
const EditImportMappingForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditImportMapping.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
EditImportMappingForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditImportMapping.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\ImportMappings\Pages\EditImportMapping::__invoke
* @see app/Filament/Resources/ImportMappings/Pages/EditImportMapping.php:7
* @route '/admin/import-mappings/{record}/edit'
*/
EditImportMappingForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditImportMapping.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditImportMapping.form = EditImportMappingForm

export default EditImportMapping