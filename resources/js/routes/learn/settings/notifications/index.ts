import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:82
 * @route '/learn/settings/notifications'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/learn/settings/notifications',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:82
 * @route '/learn/settings/notifications'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:82
 * @route '/learn/settings/notifications'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})