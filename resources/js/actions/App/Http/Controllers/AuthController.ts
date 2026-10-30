import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AuthController::showLogin
 * @see app/Http/Controllers/AuthController.php:25
 * @route '/login'
 */
export const showLogin = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showLogin.url(options),
    method: 'get',
})

showLogin.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::showLogin
 * @see app/Http/Controllers/AuthController.php:25
 * @route '/login'
 */
showLogin.url = (options?: RouteQueryOptions) => {
    return showLogin.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::showLogin
 * @see app/Http/Controllers/AuthController.php:25
 * @route '/login'
 */
showLogin.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showLogin.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::showLogin
 * @see app/Http/Controllers/AuthController.php:25
 * @route '/login'
 */
showLogin.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showLogin.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:141
 * @route '/login'
 */
export const login = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login.url(options),
    method: 'post',
})

login.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:141
 * @route '/login'
 */
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::login
 * @see app/Http/Controllers/AuthController.php:141
 * @route '/login'
 */
login.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AuthController::showRegistration
 * @see app/Http/Controllers/AuthController.php:32
 * @route '/register'
 */
export const showRegistration = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRegistration.url(options),
    method: 'get',
})

showRegistration.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::showRegistration
 * @see app/Http/Controllers/AuthController.php:32
 * @route '/register'
 */
showRegistration.url = (options?: RouteQueryOptions) => {
    return showRegistration.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::showRegistration
 * @see app/Http/Controllers/AuthController.php:32
 * @route '/register'
 */
showRegistration.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRegistration.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::showRegistration
 * @see app/Http/Controllers/AuthController.php:32
 * @route '/register'
 */
showRegistration.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showRegistration.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:183
 * @route '/register'
 */
export const register = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

register.definition = {
    methods: ["post"],
    url: '/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:183
 * @route '/register'
 */
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::register
 * @see app/Http/Controllers/AuthController.php:183
 * @route '/register'
 */
register.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AuthController::showForgotPassword
 * @see app/Http/Controllers/AuthController.php:39
 * @route '/forgot-password'
 */
export const showForgotPassword = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showForgotPassword.url(options),
    method: 'get',
})

showForgotPassword.definition = {
    methods: ["get","head"],
    url: '/forgot-password',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::showForgotPassword
 * @see app/Http/Controllers/AuthController.php:39
 * @route '/forgot-password'
 */
showForgotPassword.url = (options?: RouteQueryOptions) => {
    return showForgotPassword.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::showForgotPassword
 * @see app/Http/Controllers/AuthController.php:39
 * @route '/forgot-password'
 */
showForgotPassword.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showForgotPassword.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::showForgotPassword
 * @see app/Http/Controllers/AuthController.php:39
 * @route '/forgot-password'
 */
showForgotPassword.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showForgotPassword.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::sendPasswordResetLink
 * @see app/Http/Controllers/AuthController.php:44
 * @route '/forgot-password'
 */
export const sendPasswordResetLink = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendPasswordResetLink.url(options),
    method: 'post',
})

sendPasswordResetLink.definition = {
    methods: ["post"],
    url: '/forgot-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::sendPasswordResetLink
 * @see app/Http/Controllers/AuthController.php:44
 * @route '/forgot-password'
 */
sendPasswordResetLink.url = (options?: RouteQueryOptions) => {
    return sendPasswordResetLink.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::sendPasswordResetLink
 * @see app/Http/Controllers/AuthController.php:44
 * @route '/forgot-password'
 */
sendPasswordResetLink.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendPasswordResetLink.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AuthController::showResetPassword
 * @see app/Http/Controllers/AuthController.php:63
 * @route '/reset-password/{token}'
 */
export const showResetPassword = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showResetPassword.url(args, options),
    method: 'get',
})

showResetPassword.definition = {
    methods: ["get","head"],
    url: '/reset-password/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::showResetPassword
 * @see app/Http/Controllers/AuthController.php:63
 * @route '/reset-password/{token}'
 */
showResetPassword.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    token: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        token: args.token,
                }

    return showResetPassword.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::showResetPassword
 * @see app/Http/Controllers/AuthController.php:63
 * @route '/reset-password/{token}'
 */
showResetPassword.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showResetPassword.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::showResetPassword
 * @see app/Http/Controllers/AuthController.php:63
 * @route '/reset-password/{token}'
 */
showResetPassword.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showResetPassword.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::resetPassword
 * @see app/Http/Controllers/AuthController.php:71
 * @route '/reset-password'
 */
export const resetPassword = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetPassword.url(options),
    method: 'post',
})

resetPassword.definition = {
    methods: ["post"],
    url: '/reset-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::resetPassword
 * @see app/Http/Controllers/AuthController.php:71
 * @route '/reset-password'
 */
resetPassword.url = (options?: RouteQueryOptions) => {
    return resetPassword.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::resetPassword
 * @see app/Http/Controllers/AuthController.php:71
 * @route '/reset-password'
 */
resetPassword.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resetPassword.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AuthController::logout
 * @see app/Http/Controllers/AuthController.php:233
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
 * @see app/Http/Controllers/AuthController.php:233
 * @route '/logout'
 */
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::logout
 * @see app/Http/Controllers/AuthController.php:233
 * @route '/logout'
 */
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AuthController::verificationNotice
 * @see app/Http/Controllers/AuthController.php:107
 * @route '/email/verify'
 */
export const verificationNotice = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verificationNotice.url(options),
    method: 'get',
})

verificationNotice.definition = {
    methods: ["get","head"],
    url: '/email/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::verificationNotice
 * @see app/Http/Controllers/AuthController.php:107
 * @route '/email/verify'
 */
verificationNotice.url = (options?: RouteQueryOptions) => {
    return verificationNotice.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::verificationNotice
 * @see app/Http/Controllers/AuthController.php:107
 * @route '/email/verify'
 */
verificationNotice.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verificationNotice.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::verificationNotice
 * @see app/Http/Controllers/AuthController.php:107
 * @route '/email/verify'
 */
verificationNotice.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verificationNotice.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::verifyEmail
 * @see app/Http/Controllers/AuthController.php:134
 * @route '/email/verify/{id}/{hash}'
 */
export const verifyEmail = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verifyEmail.url(args, options),
    method: 'get',
})

verifyEmail.definition = {
    methods: ["get","head"],
    url: '/email/verify/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::verifyEmail
 * @see app/Http/Controllers/AuthController.php:134
 * @route '/email/verify/{id}/{hash}'
 */
verifyEmail.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                    hash: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                                hash: args.hash,
                }

    return verifyEmail.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::verifyEmail
 * @see app/Http/Controllers/AuthController.php:134
 * @route '/email/verify/{id}/{hash}'
 */
verifyEmail.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verifyEmail.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::verifyEmail
 * @see app/Http/Controllers/AuthController.php:134
 * @route '/email/verify/{id}/{hash}'
 */
verifyEmail.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verifyEmail.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::resendVerification
 * @see app/Http/Controllers/AuthController.php:118
 * @route '/email/verification-notification'
 */
export const resendVerification = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendVerification.url(options),
    method: 'post',
})

resendVerification.definition = {
    methods: ["post"],
    url: '/email/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AuthController::resendVerification
 * @see app/Http/Controllers/AuthController.php:118
 * @route '/email/verification-notification'
 */
resendVerification.url = (options?: RouteQueryOptions) => {
    return resendVerification.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::resendVerification
 * @see app/Http/Controllers/AuthController.php:118
 * @route '/email/verification-notification'
 */
resendVerification.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: resendVerification.url(options),
    method: 'post',
})
const AuthController = { showLogin, login, showRegistration, register, showForgotPassword, sendPasswordResetLink, showResetPassword, resetPassword, logout, verificationNotice, verifyEmail, resendVerification }

export default AuthController