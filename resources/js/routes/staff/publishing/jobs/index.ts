import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:424
 * @route '/staff/publishing/jobs/{jobPost}'
 */
export const update = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/publishing/jobs/{jobPost}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:424
 * @route '/staff/publishing/jobs/{jobPost}'
 */
update.url = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { jobPost: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { jobPost: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    jobPost: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        jobPost: typeof args.jobPost === 'object'
                ? args.jobPost.id
                : args.jobPost,
                }

    return update.definition.url
            .replace('{jobPost}', parsedArgs.jobPost.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:424
 * @route '/staff/publishing/jobs/{jobPost}'
 */
update.put = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::close
 * @see app/Http/Controllers/StaffPublishingController.php:482
 * @route '/staff/publishing/jobs/{jobPost}'
 */
export const close = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: close.url(args, options),
    method: 'delete',
})

close.definition = {
    methods: ["delete"],
    url: '/staff/publishing/jobs/{jobPost}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::close
 * @see app/Http/Controllers/StaffPublishingController.php:482
 * @route '/staff/publishing/jobs/{jobPost}'
 */
close.url = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { jobPost: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { jobPost: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    jobPost: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        jobPost: typeof args.jobPost === 'object'
                ? args.jobPost.id
                : args.jobPost,
                }

    return close.definition.url
            .replace('{jobPost}', parsedArgs.jobPost.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::close
 * @see app/Http/Controllers/StaffPublishingController.php:482
 * @route '/staff/publishing/jobs/{jobPost}'
 */
close.delete = (args: { jobPost: number | { id: number } } | [jobPost: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: close.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:238
 * @route '/staff/publishing/jobs'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/publishing/jobs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:238
 * @route '/staff/publishing/jobs'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::store
 * @see app/Http/Controllers/StaffPublishingController.php:238
 * @route '/staff/publishing/jobs'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const jobs = {
    update: Object.assign(update, update),
close: Object.assign(close, close),
store: Object.assign(store, store),
}

export default jobs