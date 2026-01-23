import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ListSubcategories::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ListSubcategories.php:7
* @route '/admin/subcategories'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\CreateSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/CreateSubcategory.php:7
* @route '/admin/subcategories/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
const viewForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
viewForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\ViewSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/ViewSubcategory.php:7
* @route '/admin/subcategories/{record}'
*/
viewForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: view.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

view.form = viewForm

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/subcategories/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
const editForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
editForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Subcategories\Pages\EditSubcategory::__invoke
* @see app/Filament/Resources/Subcategories/Pages/EditSubcategory.php:7
* @route '/admin/subcategories/{record}/edit'
*/
editForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

const subcategories = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    view: Object.assign(view, view),
    edit: Object.assign(edit, edit),
}

export default subcategories