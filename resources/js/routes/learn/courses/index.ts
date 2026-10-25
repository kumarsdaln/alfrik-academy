import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:143
 * @route '/learn/courses'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/learn/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:143
 * @route '/learn/courses'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:143
 * @route '/learn/courses'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::index
 * @see app/Http/Controllers/StudentLearningController.php:143
 * @route '/learn/courses'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:234
 * @route '/learn/courses/{course}'
 */
export const show = (args: { course: string | number | { slug: string | number } } | [course: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:234
 * @route '/learn/courses/{course}'
 */
show.url = (args: { course: string | number | { slug: string | number } } | [course: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { course: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    course: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        course: typeof args.course === 'object'
                ? args.course.slug
                : args.course,
                }

    return show.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:234
 * @route '/learn/courses/{course}'
 */
show.get = (args: { course: string | number | { slug: string | number } } | [course: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:234
 * @route '/learn/courses/{course}'
 */
show.head = (args: { course: string | number | { slug: string | number } } | [course: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})
const courses = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
}

export default courses