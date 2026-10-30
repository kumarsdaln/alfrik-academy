import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
export const update = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/sessions/{liveSession}/attendance',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
update.url = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
update.put = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
const attendance = {
    update: Object.assign(update, update),
}

export default attendance