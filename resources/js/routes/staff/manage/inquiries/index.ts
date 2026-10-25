import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
export const update = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/manage/inquiries/{inquiryId}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
update.url = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{inquiryId}', parsedArgs.inquiryId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:269
 * @route '/staff/manage/inquiries/{inquiryId}'
 */
update.patch = (args: { inquiryId: string | number } | [inquiryId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})
const inquiries = {
    update: Object.assign(update, update),
}

export default inquiries