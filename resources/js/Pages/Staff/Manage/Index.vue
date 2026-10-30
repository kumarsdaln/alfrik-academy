<script setup>
import { index as adminCourses } from '../../../actions/App/Http/Controllers/Staff/AdminCourseController';
import { index as adminStories } from '../../../actions/App/Http/Controllers/Staff/AdminStoryController';
import { index as adminEvents } from '../../../actions/App/Http/Controllers/Staff/AdminWebinarEventController';
import { index as adminPublicPages } from '../../../actions/App/Http/Controllers/Staff/AdminPublicPageController';
import { sessions as adminSessions, users as adminUsers, reviews as adminReviews, inquiries as adminInquiries, audit as adminAudit } from '../../../actions/App/Http/Controllers/Staff/AdminOperationsController';
import { index as adminAssessments } from '../../../actions/App/Http/Controllers/Staff/AdminAssessmentController';
import { index as publishingIndex } from '../../../actions/App/Http/Controllers/StaffPublishingController';
import { reports as reportsPage, surveys as surveysPage } from '../../../actions/App/Http/Controllers/StaffPublishingController';
import { Link } from '@inertiajs/vue3';
import StaffAdminLayout from '../../../Layouts/StaffAdminLayout.vue';

defineProps({ counts: Object });
const sections = [
  { title: 'Learning operations', description: 'Build programs and support learners through each stage.', items: [
    ['Courses & curriculum', adminCourses().url, 'Create and update courses, modules, and lesson content.', 'book-open'],
    ['Cohorts & live classes', adminSessions().url, 'Set up cohorts, teaching teams, and session schedules.', 'calendar'],
    ['Assignments & quizzes', adminAssessments().url, 'Create learner work, answer keys, and assessment availability.', 'clipboard-list'],
    ['Course reviews', adminReviews().url, 'Review and moderate feedback on your courses.', 'star'],
  ]},
  { title: 'Community & publishing', description: 'Keep the public academy current and useful.', items: [
    ['Webinars & events', adminEvents().url, 'Schedule events, manage registrations, and share joining details.', 'calendar'],
    ['Learner stories', adminStories().url, 'Manage the learner stories featured across the site.', 'message-circle'],
    ['Content & opportunities', publishingIndex().url, 'Publish articles, academy updates, and opportunities.', 'file-text'],
    ['Surveys', surveysPage().url, 'Publish surveys and manage participation forms.', 'clipboard-list'],
    ['Research reports', reportsPage().url, 'Maintain evidence-led reports for the knowledge hub.', 'file-text'],
    ['About, how & FAQs', adminPublicPages().url, 'Update the academy story and answers for prospective learners.', 'layout'],
  ]},
  { title: 'People & administration', description: 'Manage access, requests, and accountability.', items: [
    ['People & access', adminUsers().url, 'Manage accounts, staff roles, and access.', 'users'],
    ['Contact inbox', adminInquiries().url, 'Track questions from learners and partners.', 'mail'],
    ['Audit history', adminAudit().url, 'Review administrative changes and activity.', 'activity'],
  ]},
];
</script>

<template>
  <StaffAdminLayout>
    <div class="admin-heading manage-heading">
      <div><div class="eyebrow">ACADEMY CONTROL CENTER</div><h1>Manage Alfrik Academy</h1><p>A clear view of your programs, community, and day-to-day operations.</p></div>
      <span class="manage-status"><i></i> Workspace overview</span>
    </div>
    <section class="manage-metrics" aria-label="Academy overview">
      <article v-for="(count, label) in counts" :key="label"><span>{{ label }}</span><b>{{ count }}</b><small>Current total</small></article>
    </section>
    <section v-for="section in sections" :key="section.title" class="manage-section">
      <header><div><h2>{{ section.title }}</h2><p>{{ section.description }}</p></div><span>{{ section.items.length }} workspaces</span></header>
      <div class="manage-grid">
        <Link v-for="item in section.items" :key="item[1]" :href="item[1]" class="manage-card">
          <span class="manage-card-icon"><UiIcon :name="item[3]" :size="17"/></span>
          <span class="manage-card-copy"><b>{{ item[0] }}</b><small>{{ item[2] }}</small></span>
          <span class="manage-card-action">Open <UiIcon name="arrow-up-right" :size="13"/></span>
        </Link>
      </div>
    </section>
  </StaffAdminLayout>
</template>

<style scoped>
.manage-heading{align-items:flex-end}.manage-heading h1{margin-top:9px}.manage-status{display:inline-flex;align-items:center;gap:8px;padding:9px 11px;border:1px solid var(--academy-border);background:var(--academy-surface);color:var(--academy-muted);font-size:10px;white-space:nowrap}.manage-status i{width:7px;height:7px;border-radius:50%;background:var(--academy-success);box-shadow:0 0 0 3px var(--academy-success-surface)}
.manage-metrics{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));margin-bottom:36px;border:1px solid var(--academy-border);background:var(--academy-surface)}.manage-metrics article{display:grid;gap:6px;min-width:0;padding:16px 17px;border-right:1px solid var(--academy-border)}.manage-metrics article:last-child{border-right:0}.manage-metrics article>span{overflow:hidden;color:var(--academy-muted);font-size:9px;text-overflow:ellipsis;white-space:nowrap}.manage-metrics b{color:var(--academy-ink);font:500 27px/1 var(--serif,Georgia,serif)}.manage-metrics small{color:var(--academy-muted);font-size:9px}
.manage-section{margin:0 0 34px}.manage-section>header{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:13px}.manage-section h2{margin:0;color:var(--academy-ink);font:500 22px/1.15 var(--serif,Georgia,serif);letter-spacing:-.02em}.manage-section header p{margin:5px 0 0;color:var(--academy-muted);font-size:11px;line-height:1.5}.manage-section header>span{padding-bottom:2px;color:var(--academy-muted);font-size:9px;white-space:nowrap}.manage-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.manage-card{display:grid;grid-template-columns:36px minmax(0,1fr) auto;align-items:center;gap:13px;min-width:0;padding:15px 16px;border:1px solid var(--academy-border);background:var(--academy-surface);color:inherit;text-decoration:none;transition:border-color .16s,background-color .16s,transform .16s}.manage-card:hover{transform:translateY(-1px);border-color:var(--academy-border-strong);background:var(--academy-brand-wash)}.manage-card-icon{display:grid;width:36px;height:36px;place-items:center;background:var(--academy-primary-soft);color:var(--academy-secondary)}.manage-card-copy{display:grid;min-width:0;gap:4px}.manage-card-copy b{color:var(--academy-ink);font-size:12px;font-weight:650}.manage-card-copy small{color:var(--academy-muted);font-size:10px;line-height:1.5}.manage-card-action{display:inline-flex;align-items:center;gap:5px;color:var(--academy-secondary);font-size:10px;font-weight:650;white-space:nowrap}
@media(max-width:1120px){.manage-metrics{grid-template-columns:repeat(3,minmax(0,1fr))}.manage-metrics article:nth-child(3){border-right:0}.manage-metrics article:nth-child(n+4){border-top:1px solid var(--academy-border)}}
@media(max-width:700px){.manage-heading{align-items:flex-start;flex-direction:column}.manage-status{padding:7px 9px}.manage-metrics{grid-template-columns:repeat(2,minmax(0,1fr));margin-bottom:28px}.manage-metrics article{padding:13px}.manage-metrics article:nth-child(3){border-right:1px solid var(--academy-border)}.manage-metrics article:nth-child(even){border-right:0}.manage-metrics article:nth-child(n+3){border-top:1px solid var(--academy-border)}.manage-section{margin-bottom:26px}.manage-section>header{align-items:flex-start}.manage-grid{grid-template-columns:1fr;gap:8px}.manage-card{grid-template-columns:34px minmax(0,1fr) auto;gap:10px;padding:12px}.manage-card-icon{width:34px;height:34px}}
@media(max-width:390px){.manage-card{grid-template-columns:32px minmax(0,1fr);gap:9px}.manage-card-action{grid-column:2;justify-self:start}.manage-metrics article>span{font-size:8px}}
</style>