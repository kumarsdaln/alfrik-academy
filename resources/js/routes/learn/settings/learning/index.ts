import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:74
 * @route '/learn/settings/learning'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/learn/settings/learning',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:74
 * @route '/learn/settings/learning'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:74
 * @route '/learn/settings/learning'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})