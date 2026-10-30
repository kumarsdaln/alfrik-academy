<script setup>
import { dashboard as wayfinderDashboard1, course as wayfinderCourse2 } from './../../actions/App/Http/Controllers/StudentLearningController';
import { courses as wayfinderCourses3 } from './../../actions/App/Http/Controllers/PublicController';

import { InfiniteScroll, Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';

defineProps({ activity: Object });
const icons = { lesson: 'book-open', enrollment: 'check-circle', assignment: 'clipboard-list', quiz: 'bar-chart', live: 'calendar', payment: 'credit-card', application: 'briefcase', event: 'calendar' };
const typeLabels = { lesson: 'LESSON COMPLETED', enrollment: 'COURSE ENROLLMENT', assignment: 'ASSIGNMENT', quiz: 'QUIZ', live: 'LIVE CLASS', payment: 'PAYMENT', application: 'APPLICATION', event: 'EVENT' };
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="activity" />
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderDashboard1().url"><UiIcon name="arrow-left" /> Learning home</Link><span>Your Alfrik account</span></header>
      <div class="dash-content account-page-content activity-page-content"><div class="learner-index-heading"><div><div class="eyebrow">YOUR LEARNING RECORD</div><h1>Learning activity</h1><p>A running record of classes attended, lessons finished, and work submitted.</p></div></div>
        <section v-if="activity.data.length" class="activity-record" aria-label="Recent learning activity">
          <div class="activity-record-heading"><h2>Recent activity</h2><span>Newest first · {{ activity.data.length }} loaded</span></div>
          <InfiniteScroll data="activity" :buffer="450" :manual-after="4" class="activity-timeline">
            <article v-for="item in activity.data" :key="`${item.type}-${item.id}`" class="activity-entry">
            <span class="activity-entry-icon"><UiIcon :name="icons[item.type] || 'activity'" /></span>
            <div class="activity-entry-copy"><span class="activity-entry-kind">{{ typeLabels[item.type] || 'LEARNING ACTIVITY' }}</span><h3>{{ item.title }}</h3><p>{{ item.detail }}</p></div>
            <time class="activity-entry-time" :datetime="item.at">{{ new Date(item.at).toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' }) }}</time>
            <Link v-if="item.courseSlug" class="activity-entry-link" :href="wayfinderCourse2.url({ course: item.courseSlug })"><span>Open course</span><UiIcon name="arrow-up-right" /></Link>
                      </article>
            <template #next="{ loading, manualMode, hasMore, fetch }">
              <div v-if="loading || (manualMode && hasMore)" class="activity-load-more" aria-live="polite">
                <button v-if="manualMode && hasMore" type="button" :disabled="loading" @click="fetch">{{ loading ? 'Loading more…' : 'Load older activity' }}</button>
                <span v-else-if="loading">Loading more activity…</span>
              </div>
            </template>
          </InfiniteScroll>
        </section>
        <div v-else class="schedule-empty learner-index-empty"><span><UiIcon name="activity" /></span><h2>Your learning activity will show up here.</h2><p>Once you join a course and start learning, you can revisit your progress and accomplishments here.</p><Link :href="wayfinderCourses3().url">Explore courses <UiIcon name="arrow-up-right" /></Link></div>
      </div>
    </main>
  </div>
</template>
