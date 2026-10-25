import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../wayfinder'
/**
* @see \App\Http\Controllers\PublicController::home
 * @see app/Http/Controllers/PublicController.php:22
 * @route '/'
 */
export const home = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

home.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::home
 * @see app/Http/Controllers/PublicController.php:22
 * @route '/'
 */
home.url = (options?: RouteQueryOptions) => {
    return home.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::home
 * @see app/Http/Controllers/PublicController.php:22
 * @route '/'
 */
home.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::home
 * @see app/Http/Controllers/PublicController.php:22
 * @route '/'
 */
home.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::how
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
export const how = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: how.url(options),
    method: 'get',
})

how.definition = {
    methods: ["get","head"],
    url: '/how-it-works',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::how
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
how.url = (options?: RouteQueryOptions) => {
    return how.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::how
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
how.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: how.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::how
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
how.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: how.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
export const about = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})

about.definition = {
    methods: ["get","head"],
    url: '/about',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.url = (options?: RouteQueryOptions) => {
    return about.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
export const faq = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: faq.url(options),
    method: 'get',
})

faq.definition = {
    methods: ["get","head"],
    url: '/faq',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.url = (options?: RouteQueryOptions) => {
    return faq.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: faq.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: faq.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
export const contact = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})

contact.definition = {
    methods: ["get","head"],
    url: '/contact',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.url = (options?: RouteQueryOptions) => {
    return contact.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: contact.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:22
 * @route '/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:22
 * @route '/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:22
 * @route '/login'
 */
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:22
 * @route '/login'
 */
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:29
 * @route '/register'
 */
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:29
 * @route '/register'
 */
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:29
 * @route '/register'
 */
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:29
 * @route '/register'
 */
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::logout
 * @see app/Http/Controllers/AuthController.php:149
 * @route '/logout'
 */
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::logout
 * @see app/Http/Controllers/AuthController.php:149
 * @route '/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::logout
 * @see app/Http/Controllers/AuthController.php:149
 * @route '/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentLearningController::learn
 * @see app/Http/Controllers/StudentLearningController.php:21
 * @route '/learn'
 */
export const learn = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learn.url(options),
    method: 'get',
})

learn.definition = {
    methods: ["get","head"],
    url: '/learn',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::learn
 * @see app/Http/Controllers/StudentLearningController.php:21
 * @route '/learn'
 */
learn.url = (options?: RouteQueryOptions) => {
    return learn.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::learn
 * @see app/Http/Controllers/StudentLearningController.php:21
 * @route '/learn'
 */
learn.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learn.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::learn
 * @see app/Http/Controllers/StudentLearningController.php:21
 * @route '/learn'
 */
learn.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: learn.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::staff
 * @see app/Http/Controllers/StaffController.php:89
 * @route '/staff'
 */
export const staff = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: staff.url(options),
    method: 'get',
})

staff.definition = {
    methods: ["get","head"],
    url: '/staff',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::staff
 * @see app/Http/Controllers/StaffController.php:89
 * @route '/staff'
 */
staff.url = (options?: RouteQueryOptions) => {
    return staff.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::staff
 * @see app/Http/Controllers/StaffController.php:89
 * @route '/staff'
 */
staff.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: staff.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::staff
 * @see app/Http/Controllers/StaffController.php:89
 * @route '/staff'
 */
staff.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: staff.url(options),
    method: 'head',
})