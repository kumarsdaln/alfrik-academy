import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/categories',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const categories = {
    store: Object.assign(store, store),
}

export default categories