import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
const CreateOrganization = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateOrganization.url(options),
    method: 'get',
})

CreateOrganization.definition = {
    methods: ["get","head"],
    url: '/admin/organizations/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
CreateOrganization.url = (options?: RouteQueryOptions) => {
    return CreateOrganization.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
CreateOrganization.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateOrganization.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
CreateOrganization.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateOrganization.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
const CreateOrganizationForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateOrganization.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
CreateOrganizationForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateOrganization.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Organizations\Pages\CreateOrganization::__invoke
* @see app/Filament/Resources/Organizations/Pages/CreateOrganization.php:7
* @route '/admin/organizations/create'
*/
CreateOrganizationForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateOrganization.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateOrganization.form = CreateOrganizationForm

export default CreateOrganization