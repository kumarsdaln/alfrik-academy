import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
export const show = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/sessions/{liveSession}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
show.url = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return show.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
show.get = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::show
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
show.head = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})
const sessions = {
    show: Object.assign(show, show),
}

export default sessions