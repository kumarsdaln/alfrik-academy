import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/cohorts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const cohorts = {
    store: Object.assign(store, store),
}

export default cohorts