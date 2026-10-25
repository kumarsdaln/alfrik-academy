import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/assignments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
export const update = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/assignments/{assignmentId}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
update.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { assignmentId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    assignmentId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        assignmentId: args.assignmentId,
                }

    return update.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
update.put = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
const assignments = {
    store: Object.assign(store, store),
update: Object.assign(update, update),
}

export default assignments