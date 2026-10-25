import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::update
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:24
 * @route '/staff/manage/public-pages/{pageKey}'
 */
export const update = (args: { pageKey: string | number } | [pageKey: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/public-pages/{pageKey}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::update
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:24
 * @route '/staff/manage/public-pages/{pageKey}'
 */
update.url = (args: { pageKey: string | number } | [pageKey: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { pageKey: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    pageKey: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        pageKey: args.pageKey,
                }

    return update.definition.url
            .replace('{pageKey}', parsedArgs.pageKey.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::update
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:24
 * @route '/staff/manage/public-pages/{pageKey}'
 */
update.put = (args: { pageKey: string | number } | [pageKey: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
const publicPages = {
    update: Object.assign(update, update),
}

export default publicPages