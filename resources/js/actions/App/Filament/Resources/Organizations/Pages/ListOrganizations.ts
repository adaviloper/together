import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
const ListOrganizations = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListOrganizations.url(options),
    method: 'get',
})

ListOrganizations.definition = {
    methods: ["get","head"],
    url: '/admin/organizations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
ListOrganizations.url = (options?: RouteQueryOptions) => {
    return ListOrganizations.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
ListOrganizations.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListOrganizations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
ListOrganizations.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListOrganizations.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
const ListOrganizationsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListOrganizations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
ListOrganizationsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListOrganizations.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\ListOrganizations::__invoke
* @see app/Filament/Resources/Organizations/Pages/ListOrganizations.php:7
* @route '/admin/organizations'
*/
ListOrganizationsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListOrganizations.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListOrganizations.form = ListOrganizationsForm

export default ListOrganizations