import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\OrganizationSwitcherController::update
* @see app/Http/Controllers/OrganizationSwitcherController.php:10
* @route '/organization/current'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/organization/current',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\OrganizationSwitcherController::update
* @see app/Http/Controllers/OrganizationSwitcherController.php:10
* @route '/organization/current'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\OrganizationSwitcherController::update
* @see app/Http/Controllers/OrganizationSwitcherController.php:10
* @route '/organization/current'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\OrganizationSwitcherController::update
* @see app/Http/Controllers/OrganizationSwitcherController.php:10
* @route '/organization/current'
*/
const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\OrganizationSwitcherController::update
* @see app/Http/Controllers/OrganizationSwitcherController.php:10
* @route '/organization/current'
*/
updateForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

const current = {
    update: Object.assign(update, update),
}

export default current