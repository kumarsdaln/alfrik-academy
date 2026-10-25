import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:62
 * @route '/learn/profile'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/learn/profile',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:62
 * @route '/learn/profile'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:62
 * @route '/learn/profile'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})