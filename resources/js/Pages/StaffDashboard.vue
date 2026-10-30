<script setup>
import { home as wayfinderHome1, courses as wayfinderCourses6 } from './../actions/App/Http/Controllers/PublicController';
import { dashboard as wayfinderDashboard2, reviews as wayfinderReviews3, review as wayfinderReview8, gradebook as wayfinderGradebook9 } from './../actions/App/Http/Controllers/StaffController';
import { index as wayfinderIndex4 } from './../actions/App/Http/Controllers/StaffPublishingController';
import { index as wayfinderIndex5 } from './../actions/App/Http/Controllers/Staff/AdminOperationsController';
import { logout as wayfinderLogout7 } from './../actions/App/Http/Controllers/AuthController';
import { index as notificationIndex8 } from './../actions/App/Http/Controllers/NotificationController';

import { Link, usePage } from '@inertiajs/vue3';
const page = usePage();
defineProps({ staff: Object, overview: Object, sessions: Array, submissions: Array, canReview: Boolean, canPublish: Boolean, canManage: Boolean });
</script>

<template>
  <div class="dashboard-shell">
    <aside class="dash-sidebar staff-sidebar">
      <Link class="brand" :href="wayfinderHome1().url"><BrandMark class="brand-mark" /><span>Alfrik Academy</span></Link>
      <div class="side-label">WORKSPACE</div>
      <Link class="side-link selected" :href="wayfinderDashboard2().url"><span><UiIcon name="dashboard" /></span> Overview</Link>
      <Link v-if="canReview" class="side-link" :href="wayfinderReviews3().url"><span><UiIcon name="clipboard-list" /></span> Learner work <i v-if="overview['Pending reviews'] !== '0'" class="side-ping">{{ overview['Pending reviews'] }}</i></Link>
      <Link v-if="canReview" class="side-link" :href="wayfinderGradebook9().url"><span><UiIcon name="bar-chart" /></span> Gradebook</Link>
      <Link v-if="canPublish" class="side-link" :href="wayfinderIndex4().url"><span><UiIcon name="file-text" /></span> Community publishing</Link>
      <Link v-if="canManage" class="side-link" :href="wayfinderIndex5().url"><span><UiIcon name="settings" /></span> Manage academy</Link>
      <Link class="side-link" :href="notificationIndex8().url"><span><UiIcon name="bell" /></span> Notifications <i v-if="page.props.notifications?.unreadCount" class="side-ping">{{ page.props.notifications.unreadCount > 9 ? '9+' : page.props.notifications.unreadCount }}</i></Link>
      <div class="side-label space-top">GROWTH & SETTINGS</div>
      <Link v-if="canManage" class="side-link" :href="wayfinderIndex5().url"><span><UiIcon name="bar-chart" /></span> Academy reports</Link>
      <div class="sidebar-help"><div class="help-mark"><UiIcon name="sparkles" /></div><b>Your learning community</b><p>Live classes, thoughtful feedback, and steady progress.</p><Link :href="wayfinderCourses6().url">View public courses <UiIcon name="arrow-up-right" :size="13" /></Link></div>
      <div class="user-profile"><span class="profile-avatar staff-avatar">{{ staff.name.split(' ').map(part => part[0]).slice(0, 2).join('') }}</span><span><b>{{ staff.name }}</b><small>{{ staff.role }}</small></span></div>
    </aside>
    <main class="dash-main">
      <header class="dash-top"><span>{{ new Date().toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) }}</span><div><span class="profile-avatar small staff-avatar">{{ staff.name.split(' ').map(part => part[0]).slice(0, 2).join('') }}</span><Link :href="wayfinderLogout7().url" method="post" as="button" class="dash-logout">Sign out</Link></div></header>
      <div class="dash-content staff-content">
        <div class="dash-welcome"><div><div class="eyebrow">ALFRIK ACADEMY · STAFF</div><h1>Good work starts with a good class.</h1><p>Here is what your learners and cohorts need this week.</p></div><div class="staff-actions"><Link v-if="canManage" class="button button-dark" :href="wayfinderIndex5().url"><UiIcon name="settings" /> Manage academy <UiIcon name="arrow-up-right" :size="13" /></Link><Link v-if="canReview" class="button button-dark" :href="wayfinderReviews3().url"><UiIcon name="clipboard-list" /> Review learner work <UiIcon name="arrow-up-right" :size="13" /></Link><Link v-if="canPublish" class="button button-dark" :href="wayfinderIndex4().url"><UiIcon name="file-text" /> Publish for the community <UiIcon name="arrow-up-right" :size="13" /></Link></div></div>
        <div class="overview-grid"><article v-for="(value, label) in overview" :key="label" class="overview-card"><div><span>{{ label }}</span><i><UiIcon name="arrow-up-right" :size="13" /></i></div><b>{{ value }}</b><small v-if="label === 'Active learners'">Across your active cohorts</small><small v-else-if="label === 'Live this week'">Upcoming scheduled sessions</small><small v-else-if="label === 'Pending reviews'">{{ canReview ? 'Work waiting for feedback' : 'Staff review queue' }}</small><small v-else>Lessons completed by enrolled learners</small></article></div>
        <div class="staff-columns">
          <section class="staff-panel"><div class="dash-section-head"><div><h2>Coming up live</h2><p>Your next scheduled cohort sessions.</p></div></div><article v-for="session in sessions" :key="session.id" class="staff-session"><span class="staff-date"><b>{{ session.startsAt.split(' · ')[0] }}</b><small>{{ session.startsAt.split(' · ')[1] }}</small></span><span class="mini-avatar"><UiIcon name="users" :size="13" /></span><span class="staff-session-copy"><b>{{ session.title }}</b><small>{{ session.course }} · {{ session.teacher }}</small></span><span class="attendance">{{ session.learners }} learners</span></article><div v-if="!sessions.length" class="staff-empty"><UiIcon name="calendar" :size="18" /><span>No sessions are scheduled yet.</span></div><div class="panel-footer"><span><i class="live-dot"></i> {{ overview['Live this week'] }} sessions this week</span><Link :href="wayfinderReviews3().url" v-if="canReview">Review learner work <UiIcon name="arrow-up-right" :size="13" /></Link></div></section>
          <section v-if="canReview" class="staff-panel activity-panel"><div class="dash-section-head"><div><h2>Ready for feedback</h2><p>Give learners a clear next step.</p></div><Link :href="wayfinderReviews3().url">All submissions <UiIcon name="arrow-up-right" :size="13" /></Link></div><Link v-for="submission in submissions" :key="submission.id" :href="wayfinderReview8.url({ submissionId: submission.id })" class="staff-review-row"><span class="activity-symbol lilac-symbol"><UiIcon name="file-text" /></span><span><b>{{ submission.title }}</b><small>{{ submission.student }} · {{ submission.course }}</small></span><UiIcon name="arrow-up-right" :size="13" /></Link><div v-if="!submissions.length" class="staff-empty"><UiIcon name="check-circle" :size="18" /><span>No work is waiting for review.</span></div></section>
          <section v-else class="staff-panel activity-panel"><div class="dash-section-head"><div><h2>Learning at a glance</h2><p>Progress across your current courses.</p></div></div><div class="staff-progress"><span>{{ overview['Completion rate'] }}</span><div class="progress-bar"><span class="bar-violet" :style="{ width: overview['Completion rate'] }"></span></div><p>of lesson activities marked complete by enrolled learners</p></div><div class="staff-empty"><UiIcon name="megaphone" :size="18" /><span>Share course updates with your community.</span></div></section>
        </div>
      </div>
    </main>
  </div>
</template>
