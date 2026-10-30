import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import gradebook435704 from './gradebook'
import manage from './manage'
import publishingE1b60e from './publishing'
import reviews83e781 from './reviews'
/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
export const gradebook = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gradebook.url(options),
    method: 'get',
})

gradebook.definition = {
    methods: ["get","head"],
    url: '/staff/gradebook',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.url = (options?: RouteQueryOptions) => {
    return gradebook.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gradebook.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: gradebook.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::publishing
 * @see app/Http/Controllers/StaffPublishingController.php:20
 * @route '/staff/publishing'
 */
export const publishing = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: publishing.url(options),
    method: 'get',
})

publishing.definition = {
    methods: ["get","head"],
    url: '/staff/publishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::publishing
 * @see app/Http/Controllers/StaffPublishingController.php:20
 * @route '/staff/publishing'
 */
publishing.url = (options?: RouteQueryOptions) => {
    return publishing.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::publishing
 * @see app/Http/Controllers/StaffPublishingController.php:20
 * @route '/staff/publishing'
 */
publishing.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: publishing.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::publishing
 * @see app/Http/Controllers/StaffPublishingController.php:20
 * @route '/staff/publishing'
 */
publishing.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: publishing.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
export const reviews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})

reviews.definition = {
    methods: ["get","head"],
    url: '/staff/reviews',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.url = (options?: RouteQueryOptions) => {
    return reviews.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reviews.url(options),
    method: 'head',
})
const staff = {
    gradebook: Object.assign(gradebook, gradebook435704),
manage: Object.assign(manage, manage),
publishing: Object.assign(publishing, publishingE1b60e),
reviews: Object.assign(reviews, reviews83e781),
}

export default staff