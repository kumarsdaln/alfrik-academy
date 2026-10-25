import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/manage',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
export const audit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: audit.url(options),
    method: 'get',
})

audit.definition = {
    methods: ["get","head"],
    url: '/staff/manage/audit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.url = (options?: RouteQueryOptions) => {
    return audit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: audit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: audit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
export const users = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})

users.definition = {
    methods: ["get","head"],
    url: '/staff/manage/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.url = (options?: RouteQueryOptions) => {
    return users.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: users.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:49
 * @route '/staff/manage/users'
 */
export const storeUser = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeUser.url(options),
    method: 'post',
})

storeUser.definition = {
    methods: ["post"],
    url: '/staff/manage/users',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:49
 * @route '/staff/manage/users'
 */
storeUser.url = (options?: RouteQueryOptions) => {
    return storeUser.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:49
 * @route '/staff/manage/users'
 */
storeUser.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeUser.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:64
 * @route '/staff/manage/users/{user}'
 */
export const updateUser = (args: { user: string | number | { id: string | number } } | [user: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateUser.url(args, options),
    method: 'patch',
})

updateUser.definition = {
    methods: ["patch"],
    url: '/staff/manage/users/{user}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:64
 * @route '/staff/manage/users/{user}'
 */
updateUser.url = (args: { user: string | number | { id: string | number } } | [user: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return updateUser.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateUser
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:64
 * @route '/staff/manage/users/{user}'
 */
updateUser.patch = (args: { user: string | number | { id: string | number } } | [user: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateUser.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
export const sessions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sessions.url(options),
    method: 'get',
})

sessions.definition = {
    methods: ["get","head"],
    url: '/staff/manage/sessions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.url = (options?: RouteQueryOptions) => {
    return sessions.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sessions.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: sessions.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeCohort
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
export const storeCohort = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeCohort.url(options),
    method: 'post',
})

storeCohort.definition = {
    methods: ["post"],
    url: '/staff/manage/cohorts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeCohort
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
storeCohort.url = (options?: RouteQueryOptions) => {
    return storeCohort.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeCohort
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:103
 * @route '/staff/manage/cohorts'
 */
storeCohort.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeCohort.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
export const storeSession = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeSession.url(options),
    method: 'post',
})

storeSession.definition = {
    methods: ["post"],
    url: '/staff/manage/sessions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
storeSession.url = (options?: RouteQueryOptions) => {
    return storeSession.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::storeSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
storeSession.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeSession.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
export const updateSession = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateSession.url(args, options),
    method: 'patch',
})

updateSession.definition = {
    methods: ["patch"],
    url: '/staff/manage/sessions/{liveSession}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
updateSession.url = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return updateSession.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateSession
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
updateSession.patch = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateSession.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
export const attendance = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attendance.url(args, options),
    method: 'get',
})

attendance.definition = {
    methods: ["get","head"],
    url: '/staff/manage/sessions/{liveSession}/attendance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.url = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return attendance.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.get = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attendance.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.head = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: attendance.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateAttendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
export const updateAttendance = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateAttendance.url(args, options),
    method: 'put',
})

updateAttendance.definition = {
    methods: ["put"],
    url: '/staff/manage/sessions/{liveSession}/attendance',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateAttendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
updateAttendance.url = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return updateAttendance.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateAttendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:214
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
updateAttendance.put = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateAttendance.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
export const reviews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})

reviews.definition = {
    methods: ["get","head"],
    url: '/staff/manage/reviews',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.url = (options?: RouteQueryOptions) => {
    return reviews.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reviews.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateReview
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
export const updateReview = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateReview.url(args, options),
    method: 'patch',
})

updateReview.definition = {
    methods: ["patch"],
    url: '/staff/manage/reviews/{review}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateReview
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
updateReview.url = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { review: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { review: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    review: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        review: typeof args.review === 'object'
                ? args.review.id
                : args.review,
                }

    return updateReview.definition.url
            .replace('{review}', parsedArgs.review.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateReview
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
updateReview.patch = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateReview.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
export const inquiries = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inquiries.url(options),
    method: 'get',
})

inquiries.definition = {
    methods: ["get","head"],
    url: '/staff/manage/inquiries',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.url = (options?: RouteQueryOptions) => {
    return inquiries.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inquiries.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: inquiries.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateInquiry
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
export const updateInquiry = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateInquiry.url(args, options),
    method: 'patch',
})

updateInquiry.definition = {
    methods: ["patch"],
    url: '/staff/manage/inquiries/{inquiryId}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateInquiry
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
updateInquiry.url = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { inquiryId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    inquiryId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        inquiryId: args.inquiryId,
                }

    return updateInquiry.definition.url
            .replace('{inquiryId}', parsedArgs.inquiryId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::updateInquiry
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
updateInquiry.patch = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateInquiry.url(args, options),
    method: 'patch',
})
const AdminOperationsController = { index, audit, users, storeUser, updateUser, sessions, storeCohort, storeSession, updateSession, attendance, updateAttendance, reviews, updateReview, inquiries, updateInquiry }

export default AdminOperationsController