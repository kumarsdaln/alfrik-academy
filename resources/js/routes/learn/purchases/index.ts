import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentBillingController::returnMethod
 * @see app/Http/Controllers/StudentBillingController.php:267
 * @route '/learn/purchases/return'
 */
export const returnMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: returnMethod.url(options),
    method: 'get',
})

returnMethod.definition = {
    methods: ["get","head"],
    url: '/learn/purchases/return',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::returnMethod
 * @see app/Http/Controllers/StudentBillingController.php:267
 * @route '/learn/purchases/return'
 */
returnMethod.url = (options?: RouteQueryOptions) => {
    return returnMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::returnMethod
 * @see app/Http/Controllers/StudentBillingController.php:267
 * @route '/learn/purchases/return'
 */
returnMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: returnMethod.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::returnMethod
 * @see app/Http/Controllers/StudentBillingController.php:267
 * @route '/learn/purchases/return'
 */
returnMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: returnMethod.url(options),
    method: 'head',
})
const purchases = {
    return: Object.assign(returnMethod, returnMethod),
}

export default purchases