import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/security'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/learn/settings/security',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/security'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/security'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})