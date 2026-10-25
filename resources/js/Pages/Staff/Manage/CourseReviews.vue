<script setup>
import { updateReview as wayfinderUpdateReview1 } from './../../../actions/App/Http/Controllers/Staff/AdminOperationsController';

import { reviews as manageReviewsRoute } from '../../../actions/App/Http/Controllers/Staff/AdminOperationsController';
import { router } from '@inertiajs/vue3';
import StaffAdminLayout from '../../../Layouts/StaffAdminLayout.vue';

defineProps({ reviews: Object });
function moderate(review, is_published) { router.patch(wayfinderUpdateReview1.url({ review: review.id }), { is_published }, { preserveScroll: true }); }
</script>

<template><StaffAdminLayout><div class="admin-heading"><div><div class="eyebrow">LEARNER VOICE</div><h1>Course reviews.</h1><p>Review learner feedback and decide what appears on public course pages.</p></div></div><section class="admin-panel"><div v-for="review in reviews.data" :key="review.id" class="review-row"><span class="review-rating"><UiIcon v-for="n in review.rating" :key="n" name="star" :size="13"/></span><blockquote>“{{ review.body || 'No written feedback.' }}”</blockquote><div class="review-footer"><span><b>{{ review.user.name }}</b><small>{{ review.course.title }} · {{ review.user.email }}</small></span><label><input :checked="review.is_published" type="checkbox" @change="moderate(review, $event.target.checked)"> Public</label></div></div><div v-if="!reviews.data.length" class="admin-empty">No course reviews have been submitted.</div><div class="admin-pagination"><span>Page {{ reviews.current_page }} of {{ reviews.last_page }}</span><div><a v-if="reviews.prev_page_url"  :href="manageReviewsRoute.url({mergeQuery: {page: reviews.current_page - 1}})">← Newer</a><a v-if="reviews.next_page_url"  :href="manageReviewsRoute.url({mergeQuery: {page: reviews.current_page + 1}})">Older →</a></div></div></section></StaffAdminLayout></template>

<style scoped>.review-row{border-bottom:1px solid #efeee9;padding:18px 4px}.review-rating{display:flex;gap:3px;color:#b48a42}.review-row blockquote{font:400 1.1rem/1.55 var(--serif,Georgia,serif);margin:13px 0;color:#41493e}.review-footer{display:flex;align-items:center;justify-content:space-between}.review-footer>span{display:grid;gap:4px}.review-footer small{font-size:11px;color:#777e74}.review-footer label{font-size:11px;color:#62695f;display:flex;align-items:center;gap:6px}.admin-pagination{display:flex;justify-content:space-between;font-size:11px;color:#71796f;padding-top:15px}.admin-pagination div{display:flex;gap:14px}.admin-pagination a{color:#53684a}</style>
