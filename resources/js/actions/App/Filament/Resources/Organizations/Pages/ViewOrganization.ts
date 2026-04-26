import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
const ViewOrganization = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewOrganization.url(args, options),
    method: 'get',
})

ViewOrganization.definition = {
    methods: ["get","head"],
    url: '/admin/organizations/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
ViewOrganization.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewOrganization.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
ViewOrganization.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewOrganization.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
ViewOrganization.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewOrganization.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
const ViewOrganizationForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewOrganization.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
ViewOrganizationForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewOrganization.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ViewOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/ViewOrganization.php:7
* @route '/admin/organizations/{record}'
*/
ViewOrganizationForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ViewOrganization.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ViewOrganization.form = ViewOrganizationForm

export default ViewOrganization