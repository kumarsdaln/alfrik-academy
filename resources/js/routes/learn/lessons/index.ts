import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:394
 * @route '/learn/lessons/{lesson}'
 */
export const show = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/lessons/{lesson}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:394
 * @route '/learn/lessons/{lesson}'
 */
show.url = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { lesson: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { lesson: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    lesson: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        lesson: typeof args.lesson === 'object'
                ? args.lesson.id
                : args.lesson,
                }

    return show.definition.url
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:394
 * @route '/learn/lessons/{lesson}'
 */
show.get = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:394
 * @route '/learn/lessons/{lesson}'
 */
show.head = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::complete
 * @see app/Http/Controllers/StudentLearningController.php:423
 * @route '/learn/lessons/{lesson}/complete'
 */
export const complete = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})

complete.definition = {
    methods: ["post"],
    url: '/learn/lessons/{lesson}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::complete
 * @see app/Http/Controllers/StudentLearningController.php:423
 * @route '/learn/lessons/{lesson}/complete'
 */
complete.url = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { lesson: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { lesson: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    lesson: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        lesson: typeof args.lesson === 'object'
                ? args.lesson.id
                : args.lesson,
                }

    return complete.definition.url
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::complete
 * @see app/Http/Controllers/StudentLearningController.php:423
 * @route '/learn/lessons/{lesson}/complete'
 */
complete.post = (args: { lesson: string | number | { id: string | number } } | [lesson: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: complete.url(args, options),
    method: 'post',
})
const lessons = {
    show: Object.assign(show, show),
complete: Object.assign(complete, complete),
}

export default lessons