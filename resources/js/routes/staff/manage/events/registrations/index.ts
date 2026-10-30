import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
export const update = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/manage/events/{webinarEvent}/registrations/{registration}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
update.url = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    webinarEvent: args[0],
                    registration: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        webinarEvent: typeof args.webinarEvent === 'object'
                ? args.webinarEvent.id
                : args.webinarEvent,
                                registration: typeof args.registration === 'object'
                ? args.registration.id
                : args.registration,
                }

    return update.definition.url
            .replace('{webinarEvent}', parsedArgs.webinarEvent.toString())
            .replace('{registration}', parsedArgs.registration.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
update.patch = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})
const registrations = {
    update: Object.assign(update, update),
}

export default registrations