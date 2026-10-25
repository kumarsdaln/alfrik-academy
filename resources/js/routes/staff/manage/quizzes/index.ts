import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/quizzes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::store
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
export const update = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/manage/quizzes/{quizId}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
update.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quizId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    quizId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        quizId: args.quizId,
                }

    return update.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::update
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
update.patch = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})
const quizzes = {
    store: Object.assign(store, store),
update: Object.assign(update, update),
}

export default quizzes