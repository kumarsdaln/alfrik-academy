<script setup>
import { grade as wayfinderGrade1, dashboard as wayfinderDashboard3, reviews as wayfinderReviews4 } from './../../actions/App/Http/Controllers/StaffController';
import { home as wayfinderHome2 } from './../../actions/App/Http/Controllers/PublicController';

import { Link, useForm } from '@inertiajs/vue3';
const props = defineProps({ submission: Object });
const form = useForm({ score: '', feedback: '' });
function submit() { form.post(wayfinderGrade1.url({ submissionId: props.submission.id })); }
</script>

<template>
  <div class="dashboard-shell">
    <aside class="dash-sidebar staff-sidebar"><Link class="brand" :href="wayfinderHome2().url"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link><div class="side-label">WORKSPACE</div><Link class="side-link" :href="wayfinderDashboard3().url"><span><UiIcon name="dashboard" /></span> Overview</Link><Link class="side-link selected" :href="wayfinderReviews4().url"><span><UiIcon name="clipboard-list" /></span> Learner work</Link><div class="side-label space-top">GROWTH & SETTINGS</div><div class="side-link side-link-muted"><span><UiIcon name="users" /></span> People</div><div class="side-link side-link-muted"><span><UiIcon name="bar-chart" /></span> Analytics</div><div class="sidebar-help"><div class="help-mark"><UiIcon name="sparkles" /></div><b>Feedback is part of the lesson.</b><p>Be specific, kind, and clear about what to try next.</p></div></aside>
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderReviews4().url"><UiIcon name="arrow-left" :size="13" /> All learner work</Link><span>{{ submission.course }}</span></header><div class="dash-content staff-review-content"><div class="staff-review-heading"><div><div class="eyebrow">{{ submission.student }} · {{ submission.email }}</div><h1>{{ submission.title }}</h1><p>{{ submission.course }} · Submitted {{ new Date(submission.submittedAt).toLocaleString() }}</p></div><div class="staff-max-points"><b>{{ submission.maxPoints }}</b><span>points possible</span></div></div><article class="staff-submission-response"><div class="eyebrow">LEARNER SUBMISSION</div><p>{{ submission.response }}</p></article><form class="staff-grade-form" @submit.prevent="submit"><div class="eyebrow">YOUR REVIEW</div><h2>Share a useful next step.</h2><label>Score <span>out of {{ submission.maxPoints }}</span><input v-model="form.score" type="number" min="0" :max="submission.maxPoints" step="0.01" required><small v-if="form.errors.score" class="quiz-error">{{ form.errors.score }}</small></label><label>Feedback<textarea v-model="form.feedback" required minlength="5" maxlength="10000" rows="7" placeholder="Name what is working, what could be clearer, and one next step to try…"></textarea><small v-if="form.errors.feedback" class="quiz-error">{{ form.errors.feedback }}</small></label><div class="staff-grade-actions"><Link :href="wayfinderReviews4().url">Cancel</Link><button class="button button-dark" type="submit" :disabled="form.processing">{{ form.processing ? 'Sharing feedback…' : 'Share feedback' }} <UiIcon name="arrow-up-right" :size="13" /></button></div></form></div></main>
  </div>
</template>
