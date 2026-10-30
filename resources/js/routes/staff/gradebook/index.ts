import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffController::exportMethod
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})

exportMethod.definition = {
    methods: ["get","head"],
    url: '/staff/gradebook/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::exportMethod
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::exportMethod
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::exportMethod
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportMethod.url(options),
    method: 'head',
})
const gradebook = {
    export: Object.assign(exportMethod, exportMethod),
}

export default gradebook