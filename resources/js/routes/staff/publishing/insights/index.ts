import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
export const update = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/publishing/insights/{insight}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
update.url = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { insight: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { insight: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    insight: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        insight: typeof args.insight === 'object'
                ? args.insight.id
                : args.insight,
                }

    return update.definition.url
            .replace('{insight}', parsedArgs.insight.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
update.put = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::destroy
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
export const destroy = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/staff/publishing/insights/{insight}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::destroy
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
destroy.url = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { insight: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { insight: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    insight: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        insight: typeof args.insight === 'object'
                ? args.insight.id
                : args.insight,
                }

    return destroy.definition.url
            .replace('{insight}', parsedArgs.insight.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::destroy
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
destroy.delete = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/publishing/insights',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const insights = {
    update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
store: Object.assign(store, store),
}

export default insights