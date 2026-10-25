<script setup>
import { home as wayfinderHome1 } from './../../actions/App/Http/Controllers/PublicController';
import { dashboard as wayfinderDashboard2, reviews as wayfinderReviews3, review as wayfinderReview4 } from './../../actions/App/Http/Controllers/StaffController';

import { Link } from '@inertiajs/vue3';
defineProps({ submissions: Object });
</script>

<template>
  <div class="dashboard-shell">
    <aside class="dash-sidebar staff-sidebar"><Link class="brand" :href="wayfinderHome1().url"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link><div class="side-label">WORKSPACE</div><Link class="side-link" :href="wayfinderDashboard2().url"><span><UiIcon name="dashboard" /></span> Overview</Link><Link class="side-link selected" :href="wayfinderReviews3().url"><span><UiIcon name="clipboard-list" /></span> Learner work</Link><div class="side-label space-top">GROWTH & SETTINGS</div><div class="side-link side-link-muted"><span><UiIcon name="users" /></span> People</div><div class="side-link side-link-muted"><span><UiIcon name="bar-chart" /></span> Analytics</div><div class="sidebar-help"><div class="help-mark"><UiIcon name="sparkles" /></div><b>Useful feedback moves work forward.</b><p>Help each learner see their next step.</p></div></aside>
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderDashboard2().url"><UiIcon name="arrow-left" :size="13" /> Staff overview</Link><span>{{ submissions.total }} to review</span></header><div class="dash-content staff-content staff-review-content"><div class="eyebrow">TEACHING WORKSPACE</div><h1>Learner work</h1><p class="staff-review-intro">Review submitted projects, add a score, and share feedback the learner can use in their next live session.</p><template v-if="submissions.data.length"><div class="staff-review-list"><Link v-for="submission in submissions.data" :key="submission.id" :href="wayfinderReview4.url({ submissionId: submission.id })" class="staff-review-card"><span class="staff-review-document"><UiIcon name="file-text" /></span><span class="staff-review-card-main"><small>{{ submission.course }}</small><b>{{ submission.title }}</b><span>Submitted by {{ submission.student }}</span></span><span class="staff-review-card-date">{{ new Date(submission.submittedAt).toLocaleDateString() }}</span><UiIcon name="arrow-up-right" :size="14" /></Link></div><nav v-if="submissions.last_page > 1" class="learning-pagination" aria-label="Submission pages"><Link v-for="(link, index) in submissions.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link></nav></template><div v-else class="staff-review-empty"><span><UiIcon name="check-circle" :size="23" /></span><h2>You are all caught up.</h2><p>New learner submissions will appear here when they are ready for feedback.</p><Link :href="wayfinderDashboard2().url">Back to your overview</Link></div></div></main>
  </div>
</template>


