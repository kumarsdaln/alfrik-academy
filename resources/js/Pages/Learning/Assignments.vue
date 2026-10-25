<script setup>
import { Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';
import { dashboard as wayfinderDashboard, courses as wayfinderCourses, assignment as wayfinderAssignment, assignments as wayfinderAssignments } from '../../actions/App/Http/Controllers/StudentLearningController';

defineProps({ assignments: Object, activeFilter: String, counts: Object });

function isOverdue(assignment) {
  return assignment.status === 'to-do' && assignment.dueAt && new Date(assignment.dueAt) < new Date();
}
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="assignments" :assignment-count="counts['to-do']" />
    <main class="dash-main">
      <header class="dash-top">
        <Link :href="wayfinderDashboard().url"><UiIcon name="arrow-left" class="ui-icon" :size="13" /> Learning home</Link>
        <span>Projects from your active courses</span>
      </header>
      <div class="dash-content learner-index-content">
        <div class="learner-index-heading">
          <div>
            <div class="eyebrow">PRACTICE BETWEEN LIVE CLASSES</div>
            <h1>Assignments</h1>
            <p>Put an idea to work, submit it to your mentor, and keep the feedback close.</p>
          </div>
          <Link class="button button-dark" :href="wayfinderCourses().url">Open my courses <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></Link>
        </div>

        <nav class="assignment-tabs" aria-label="Filter assignments">
          <Link :href="wayfinderAssignments({ query: { status: 'to-do' } }).url" :class="{ active: activeFilter === 'to-do' }" :aria-current="activeFilter === 'to-do' ? 'page' : undefined">To do <span>{{ counts['to-do'] }}</span></Link>
          <Link :href="wayfinderAssignments({ query: { status: 'submitted' } }).url" :class="{ active: activeFilter === 'submitted' }" :aria-current="activeFilter === 'submitted' ? 'page' : undefined">Submitted <span>{{ counts.submitted }}</span></Link>
          <Link :href="wayfinderAssignments({ query: { status: 'all' } }).url" :class="{ active: activeFilter === 'all' }" :aria-current="activeFilter === 'all' ? 'page' : undefined">All <span>{{ counts.all }}</span></Link>
        </nav>

        <template v-if="assignments.data.length">
        <div class="assignment-list">
          <article v-for="assignment in assignments.data" :key="assignment.id" class="assignment-list-card">
            <div class="assignment-list-icon" :class="{ submitted: assignment.status !== 'to-do' }">
              <UiIcon v-if="assignment.status === 'to-do'" name="clipboard-list" class="ui-icon" />
              <UiIcon v-else name="check" class="ui-icon" />
            </div>
            <div class="assignment-list-main">
              <div class="eyebrow">{{ assignment.course }}</div>
              <h2>{{ assignment.title }}</h2>
              <p>{{ assignment.instructions }}</p>
              <div class="assignment-list-meta">
                <span v-if="assignment.dueAt" :class="{ overdue: isOverdue(assignment) }">{{ isOverdue(assignment) ? 'Past due' : 'Due' }} {{ new Date(assignment.dueAt).toLocaleDateString(undefined, { dateStyle: 'medium' }) }}</span>
                <span v-else>No due date</span>
                <span v-if="assignment.submittedAt">Submitted {{ new Date(assignment.submittedAt).toLocaleDateString(undefined, { dateStyle: 'medium' }) }}</span>
                <span v-if="assignment.status === 'graded' && assignment.score !== null">Score {{ assignment.score }}</span>
              </div>
              <p v-if="assignment.feedback" class="assignment-list-feedback"><b>Mentor feedback:</b> {{ assignment.feedback }}</p>
            </div>
            <Link :href="wayfinderAssignment.url({ assignmentId: assignment.id })" class="assignment-list-action">{{ assignment.status === 'to-do' ? 'Open assignment' : 'View submission' }} <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></Link>
          </article>
        </div>
        <nav v-if="assignments.links.length > 3" class="learning-pagination" aria-label="Assignment pages">
          <Link v-for="(link, index) in assignments.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link>
        </nav>
        </template>
        <div v-else class="schedule-empty learner-index-empty">
          <span><UiIcon v-if="activeFilter === 'to-do'" name="check" class="ui-icon" /><UiIcon v-else name="clipboard-list" class="ui-icon" /></span>
          <h2>{{ activeFilter === 'to-do' ? 'You’re all caught up.' : activeFilter === 'submitted' ? 'Nothing submitted yet.' : 'No assignments yet.' }}</h2>
          <p>{{ activeFilter === 'to-do' ? 'There are no assignments waiting for you. Check the syllabus for upcoming work.' : activeFilter === 'submitted' ? 'Once you submit work, your submissions and mentor feedback will appear here.' : 'Assignments from your active courses will appear here.' }}</p>
          <Link :href="wayfinderCourses().url">Go to my courses <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></Link>
        </div>
      </div>
    </main>
  </div>
</template>
