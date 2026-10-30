import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
export const show = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/quizzes/{quizId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
show.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
show.get = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
show.head = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
export const submit = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/learn/quizzes/{quizId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
submit.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submit.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
submit.post = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})
const quizzes = {
    show: Object.assign(show, show),
submit: Object.assign(submit, submit),
}

export default quizzes