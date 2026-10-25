<script setup>
import { Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';
import ScheduleSessionRow from '../../Components/Learning/ScheduleSessionRow.vue';
import { dashboard as wayfinderDashboard, calendar as wayfinderCalendar, schedule as wayfinderSchedule } from '../../actions/App/Http/Controllers/StudentLearningController';

defineProps({ sessions: Object, activeView: String, counts: Object, timezone: String });
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="schedule" />
    <main class="dash-main">
      <header class="dash-top">
        <Link :href="wayfinderDashboard().url"><UiIcon name="arrow-left" class="ui-icon" :size="13" /> Learning home</Link>
        <span>Times shown in {{ timezone }}</span>
      </header>
      <div class="dash-content schedule-content">
        <div class="schedule-heading">
          <div>
            <div class="eyebrow">YOUR COHORT</div>
            <h1>Class schedule</h1>
            <p>Make time for the conversations, workshops, and feedback that move your work forward.</p>
          </div>
          <a class="button button-dark" :href="wayfinderCalendar().url"><UiIcon name="calendar-plus" class="ui-icon" :size="16" /> Add to calendar</a>
        </div>

        <nav class="schedule-tabs" aria-label="Filter class schedule">
          <Link :href="wayfinderSchedule({ query: { view: 'upcoming' } }).url" :class="{ active: activeView === 'upcoming' }" :aria-current="activeView === 'upcoming' ? 'page' : undefined">Upcoming <span>{{ counts.upcoming }}</span></Link>
          <Link :href="wayfinderSchedule({ query: { view: 'past' } }).url" :class="{ active: activeView === 'past' }" :aria-current="activeView === 'past' ? 'page' : undefined">Past classes <span>{{ counts.past }}</span></Link>
        </nav>

        <template v-if="sessions.data.length">
        <div class="schedule-list">
          <ScheduleSessionRow v-for="item in sessions.data" :key="item.id" :item="item" :past="activeView === 'past'" />
        </div>
        <nav v-if="sessions.links.length > 3" class="learning-pagination" aria-label="Class schedule pages">
          <Link v-for="(link, index) in sessions.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link>
        </nav>
        </template>
        <div v-else-if="activeView === 'upcoming'" class="schedule-empty">
          <span><UiIcon name="clock" class="ui-icon" /></span>
          <h2>A little space to plan.</h2>
          <p>There aren’t any live classes scheduled yet. Check back here when your mentor adds the next cohort session.</p>
          <Link :href="wayfinderDashboard().url">Return to your learning home <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></Link>
        </div>
        <div v-else class="schedule-empty">
          <span><UiIcon name="play" class="ui-icon" :size="12" /></span>
          <h2>Your replays will live here.</h2>
          <p>After a class has ended, your mentor can share its recording here for you to revisit.</p>
        </div>

        <div class="schedule-note"><p><b>Live classes are where the work comes to life.</b> Bring questions, share what you’re making, and leave with a next step.</p></div>
      </div>
    </main>
  </div>
</template>
