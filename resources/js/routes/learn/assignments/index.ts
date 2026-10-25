import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:178
 * @route '/learn/assignments'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/learn/assignments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:178
 * @route '/learn/assignments'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:178
 * @route '/learn/assignments'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:178
 * @route '/learn/assignments'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:435
 * @route '/learn/assignments/{assignmentId}'
 */
export const show = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/assignments/{assignmentId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:435
 * @route '/learn/assignments/{assignmentId}'
 */
show.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:435
 * @route '/learn/assignments/{assignmentId}'
 */
show.get = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:435
 * @route '/learn/assignments/{assignmentId}'
 */
show.head = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:465
 * @route '/learn/assignments/{assignmentId}'
 */
export const submit = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/learn/assignments/{assignmentId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:465
 * @route '/learn/assignments/{assignmentId}'
 */
submit.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submit.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::submit
 * @see app/Http/Controllers/StudentLearningController.php:465
 * @route '/learn/assignments/{assignmentId}'
 */
submit.post = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})
const assignments = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
submit: Object.assign(submit, submit),
}

export default assignments