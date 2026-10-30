import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
export const purchases = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: purchases.url(options),
    method: 'get',
})

purchases.definition = {
    methods: ["get","head"],
    url: '/learn/purchases',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.url = (options?: RouteQueryOptions) => {
    return purchases.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: purchases.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: purchases.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
export const activity = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: activity.url(options),
    method: 'get',
})

activity.definition = {
    methods: ["get","head"],
    url: '/learn/activity',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.url = (options?: RouteQueryOptions) => {
    return activity.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: activity.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: activity.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
export const events = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/learn/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::checkoutReturn
 * @see app/Http/Controllers/StudentBillingController.php:606
 * @route '/learn/purchases/return'
 */
export const checkoutReturn = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: checkoutReturn.url(options),
    method: 'get',
})

checkoutReturn.definition = {
    methods: ["get","head"],
    url: '/learn/purchases/return',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::checkoutReturn
 * @see app/Http/Controllers/StudentBillingController.php:606
 * @route '/learn/purchases/return'
 */
checkoutReturn.url = (options?: RouteQueryOptions) => {
    return checkoutReturn.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::checkoutReturn
 * @see app/Http/Controllers/StudentBillingController.php:606
 * @route '/learn/purchases/return'
 */
checkoutReturn.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: checkoutReturn.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::checkoutReturn
 * @see app/Http/Controllers/StudentBillingController.php:606
 * @route '/learn/purchases/return'
 */
checkoutReturn.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: checkoutReturn.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::checkout
 * @see app/Http/Controllers/StudentBillingController.php:18
 * @route '/courses/{slug}/checkout'
 */
export const checkout = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: checkout.url(args, options),
    method: 'post',
})

checkout.definition = {
    methods: ["post"],
    url: '/courses/{slug}/checkout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentBillingController::checkout
 * @see app/Http/Controllers/StudentBillingController.php:18
 * @route '/courses/{slug}/checkout'
 */
checkout.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { slug: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    slug: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        slug: args.slug,
                }

    return checkout.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::checkout
 * @see app/Http/Controllers/StudentBillingController.php:18
 * @route '/courses/{slug}/checkout'
 */
checkout.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: checkout.url(args, options),
    method: 'post',
})
const StudentBillingController = { purchases, activity, events, checkoutReturn, checkout }

export default StudentBillingController