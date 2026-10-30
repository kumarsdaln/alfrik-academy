<script setup>
import { home } from '../actions/App/Http/Controllers/PublicController';
import { logout } from '../actions/App/Http/Controllers/AuthController';
import { dashboard as staffDashboard } from '../actions/App/Http/Controllers/StaffController';
import { gradebook as staffGradebook } from '../actions/App/Http/Controllers/StaffController';
import { index as adminIndex, users as adminUsers, sessions as adminSessions, reviews as adminReviews, inquiries as adminInquiries, audit as adminAudit } from '../actions/App/Http/Controllers/Staff/AdminOperationsController';
import { index as adminCourses } from '../actions/App/Http/Controllers/Staff/AdminCourseController';
import { index as adminStories } from '../actions/App/Http/Controllers/Staff/AdminStoryController';
import { index as adminEvents } from '../actions/App/Http/Controllers/Staff/AdminWebinarEventController';
import { index as adminPublicPages } from '../actions/App/Http/Controllers/Staff/AdminPublicPageController';
import { index as adminAssessments } from '../actions/App/Http/Controllers/Staff/AdminAssessmentController';
import { index as publishingIndex } from '../actions/App/Http/Controllers/StaffPublishingController';
import { reports as managedReports, surveys as managedSurveys } from '../actions/App/Http/Controllers/StaffPublishingController';
import { index as notificationIndex } from '../actions/App/Http/Controllers/NotificationController';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const nav = [
  ['Control center', adminIndex().url, 'dashboard', 'reports.view'],
  ['Courses & curriculum', adminCourses().url, 'book-open', 'courses.manage'],
  ['Learner stories', adminStories().url, 'message-circle', 'marketing.manage'],
  ['Webinars & events', adminEvents().url, 'calendar', 'events.manage'],
  ['About, how & FAQs', adminPublicPages().url, 'layout', 'marketing.manage'],
  ['Cohorts & live classes', adminSessions().url, 'calendar', 'sessions.manage'],
  ['Assignments & quizzes', adminAssessments().url, 'clipboard-list', 'assessments.manage'],
  ['People & access', adminUsers().url, 'users', 'users.manage'],
  ['Gradebook', staffGradebook().url, 'bar-chart', 'assessments.grade'],
  ['Audit history', adminAudit().url, 'activity', 'audit.view'],
  ['Course reviews', adminReviews().url, 'star', 'reviews.moderate'],
  ['Contact inbox', adminInquiries().url, 'mail', 'inquiries.manage'],
  ['Content & opportunities', publishingIndex().url, 'file-text', 'marketing.manage'],
  ['Surveys', managedSurveys().url, 'clipboard-list', 'marketing.manage'],
  ['Research reports', managedReports().url, 'file-text', 'marketing.manage'],
];
const path = computed(() => page.url.split('?')[0]);
const visibleNav = computed(() => {
  const user = page.props.auth?.user;
  if (user?.roles?.includes('admin')) return nav;

  return nav.filter((item) => user?.permissions?.includes(item[3]));
});
</script>

<template>
  <div class="admin-shell">
    <aside class="admin-sidebar"><Link :href="home().url" class="admin-brand"><BrandMark class="brand-mark"/><span>Alfrik Academy<small>ADMIN WORKSPACE</small></span></Link><nav><Link v-for="item in visibleNav" :key="item[1]" :href="item[1]" :class="{ active: path === item[1] || (item[1] !== '/staff/manage' && path.startsWith(item[1])) }"><UiIcon :name="item[2]" :size="17"/>{{ item[0] }}<UiIcon name="arrow-up-right" :size="12" class="admin-link-arrow"/></Link></nav><div class="admin-sidebar-bottom"><Link :href="staffDashboard().url">← Staff overview</Link><Link :href="home().url" target="_blank">View public site <UiIcon name="arrow-up-right" :size="12"/></Link></div></aside>
    <section class="admin-workspace"><header class="admin-topbar"><div><span class="eyebrow">ALFRIK ACADEMY · ADMINISTRATION</span><b>{{ page.props.auth?.user?.name }}</b></div><div class="admin-topbar-actions"><Link :href="notificationIndex().url" class="admin-notification-link"><UiIcon name="bell" :size="16"/><span>Notifications</span><i v-if="page.props.notifications?.unreadCount">{{ page.props.notifications.unreadCount > 9 ? '9+' : page.props.notifications.unreadCount }}</i></Link><Link :href="logout().url" method="post" as="button">Sign out <UiIcon name="arrow-up-right" :size="13"/></Link></div></header><div v-if="page.props.flash?.success" class="admin-flash" role="status">{{ page.props.flash.success }}</div><main class="admin-content"><slot/></main></section>
  </div>
</template>

<style>
.admin-topbar-actions{display:flex;align-items:center;gap:18px}.admin-notification-link{display:inline-flex;align-items:center;gap:7px;color:var(--academy-secondary);font-size:11px;position:relative}.admin-notification-link i{display:grid;place-items:center;min-width:17px;height:17px;padding:0 4px;border-radius:9px;background:var(--academy-primary-soft);color:var(--academy-secondary);font-size:8px;font-style:normal;font-weight:700}
.admin-sidebar nav{min-width:0;overflow-y:auto;overscroll-behavior:contain;scrollbar-width:thin}.admin-table-wrap{max-width:100%;overflow-x:auto;overscroll-behavior-x:contain}.admin-table{min-width:680px}.admin-form input,.admin-form textarea,.admin-form select,.admin-inline-select{min-width:0;max-width:100%}.admin-form-grid>*{min-width:0}.admin-panel{min-width:0}.admin-content>*{min-width:0}
@media(max-width:700px){.admin-sidebar{position:sticky;top:0;z-index:20;box-shadow:0 4px 16px #2631230a}.admin-sidebar nav{gap:4px;padding-bottom:4px;scrollbar-width:thin}.admin-sidebar nav a{min-height:42px;padding:0 12px}.admin-topbar{height:60px;gap:12px;padding:0 14px}.admin-topbar>div{min-width:0;gap:8px}.admin-topbar .eyebrow{display:none}.admin-topbar b{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.admin-topbar button{min-height:42px;white-space:nowrap}.admin-content{padding:20px 12px 40px}.admin-flash{margin:12px 12px 0}.admin-heading{gap:10px;margin-bottom:20px}.admin-heading h1{font-size:clamp(1.9rem,8vw,2.4rem)}.admin-heading p{font-size:13px}.admin-panel{padding:15px;margin-bottom:14px;border-radius:8px}.admin-panel h2{font-size:1.3rem}.admin-table{min-width:660px}.admin-table th,.admin-table td{padding:11px 9px;font-size:11px}.admin-resource-grid{grid-template-columns:1fr;gap:10px}.admin-form{gap:13px}.admin-form input,.admin-form textarea,.admin-form select,.admin-inline-select{width:100%;min-height:42px;font-size:16px}.admin-form textarea{min-height:110px}.admin-form-actions{justify-content:stretch}.admin-form-actions>.button,.admin-form-actions>button{min-height:42px}.admin-row{align-items:flex-start;flex-wrap:wrap}.admin-row-main{min-width:0;overflow-wrap:anywhere}}
@media(max-width:700px){.admin-topbar-actions{gap:12px}.admin-notification-link{min-height:42px;gap:4px;font-size:0}.admin-notification-link i{font-size:8px}}
@media(max-width:390px){.admin-topbar{padding:0 10px}.admin-content{padding-right:10px;padding-left:10px}.admin-sidebar{padding-right:10px;padding-left:10px}.admin-brand{padding-left:3px}.admin-brand .brand-mark{width:28px;height:28px}}
</style>

<style>.admin-pagination{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:15px;color:var(--academy-muted);font-size:11px}.admin-pagination>div{display:flex;gap:14px}.admin-pagination a{color:var(--academy-secondary)}.theme-dark .admin-pagination{color:var(--academy-muted)}.theme-dark .admin-pagination a{color:var(--academy-secondary-light)}@media(max-width:520px){.admin-pagination{align-items:flex-start;flex-direction:column}}</style>
