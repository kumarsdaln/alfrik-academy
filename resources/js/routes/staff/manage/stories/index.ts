import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminStoryController::store
 * @see app/Http/Controllers/Staff/AdminStoryController.php:25
 * @route '/staff/manage/stories'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/stories',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::store
 * @see app/Http/Controllers/Staff/AdminStoryController.php:25
 * @route '/staff/manage/stories'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::store
 * @see app/Http/Controllers/Staff/AdminStoryController.php:25
 * @route '/staff/manage/stories'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::update
 * @see app/Http/Controllers/Staff/AdminStoryController.php:35
 * @route '/staff/manage/stories/{story}'
 */
export const update = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/stories/{story}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::update
 * @see app/Http/Controllers/Staff/AdminStoryController.php:35
 * @route '/staff/manage/stories/{story}'
 */
update.url = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { story: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { story: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    story: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        story: typeof args.story === 'object'
                ? args.story.id
                : args.story,
                }

    return update.definition.url
            .replace('{story}', parsedArgs.story.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::update
 * @see app/Http/Controllers/Staff/AdminStoryController.php:35
 * @route '/staff/manage/stories/{story}'
 */
update.put = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::destroy
 * @see app/Http/Controllers/Staff/AdminStoryController.php:45
 * @route '/staff/manage/stories/{story}'
 */
export const destroy = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/staff/manage/stories/{story}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::destroy
 * @see app/Http/Controllers/Staff/AdminStoryController.php:45
 * @route '/staff/manage/stories/{story}'
 */
destroy.url = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { story: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { story: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    story: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        story: typeof args.story === 'object'
                ? args.story.id
                : args.story,
                }

    return destroy.definition.url
            .replace('{story}', parsedArgs.story.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::destroy
 * @see app/Http/Controllers/Staff/AdminStoryController.php:45
 * @route '/staff/manage/stories/{story}'
 */
destroy.delete = (args: { story: number | { id: number } } | [story: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const stories = {
    store: Object.assign(store, store),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default stories