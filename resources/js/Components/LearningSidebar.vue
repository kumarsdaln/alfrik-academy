<script setup>
import { computed, onMounted, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { dashboard, courses, schedule, assignments } from '../actions/App/Http/Controllers/StudentLearningController';
import { activity, purchases, events } from '../actions/App/Http/Controllers/StudentBillingController';
import { index as notificationIndex } from '../actions/App/Http/Controllers/NotificationController';
import { home, contact } from '../actions/App/Http/Controllers/PublicController';
import { show as showProfile } from '../actions/App/Http/Controllers/StudentProfileController';

const props = defineProps({
  active: { type: String, required: true },
  student: { type: Object, default: null },
  courseCount: { type: Number, default: null },
  assignmentCount: { type: Number, default: null },
});

const page = usePage();
const name = computed(() => props.student?.name ?? page.props.auth?.user?.name ?? 'Learner');
const initials = computed(() => props.student?.initials ?? name.value.split(' ').filter(Boolean).slice(0, 2).map((part) => part[0].toUpperCase()).join(''));
const notificationCount = computed(() => page.props.notifications?.unreadCount ?? 0);
const darkMode = ref(false);

onMounted(() => {
  darkMode.value = localStorage.getItem('kanram-theme') === 'dark';
  document.documentElement.classList.toggle('theme-dark', darkMode.value);
});

function toggleTheme() {
  darkMode.value = !darkMode.value;
  document.documentElement.classList.toggle('theme-dark', darkMode.value);
  localStorage.setItem('kanram-theme', darkMode.value ? 'dark' : 'light');
}

const links = [
  { key: 'overview', label: 'Overview', href: dashboard().url, icon: 'dashboard' },
  { key: 'courses', label: 'My courses', href: courses().url, icon: 'book-open' },
  { key: 'schedule', label: 'Class calendar', href: schedule().url, icon: 'clock' },
  { key: 'events', label: 'Events & webinars', href: events().url, icon: 'calendar' },
  { key: 'notifications', label: 'Notifications', href: notificationIndex().url, icon: 'bell' },
  { key: 'assignments', label: 'Assignments', href: assignments().url, icon: 'clipboard-list' },
  { key: 'activity', label: 'Learning activity', href: activity().url, icon: 'activity' },
  { key: 'purchases', label: 'Purchases & receipts', href: purchases().url, icon: 'credit-card' },
  { key: 'profile', label: 'Profile & preferences', href: showProfile().url, icon: 'user-round' },
];
const scheduleHref = schedule().url;
</script>

<template>
  <aside class="dash-sidebar">
    <div class="learning-sidebar-head">
      <Link class="brand" :href="home().url"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link>
    </div>
    <Teleport to=".dash-top" defer>
      <div class="learning-panel-actions header-panel-actions" aria-label="Learning panel tools">
        <Link class="panel-icon-button" :href="notificationIndex().url" aria-label="Notifications" title="Notifications">
          <UiIcon name="bell" :size="17" />
          <i v-if="notificationCount" class="panel-notification-dot">{{ notificationCount > 9 ? '9+' : notificationCount }}</i>
        </Link>
        <button class="panel-icon-button" type="button" :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'" :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'" @click="toggleTheme">
          <UiIcon :name="darkMode ? 'sun' : 'moon'" :size="17" />
        </button>
      </div>
    </Teleport>
    <div class="side-label">YOUR LEARNING</div>
    <nav class="learning-nav" aria-label="Your learning">
      <Link v-for="item in links" :key="item.key" class="side-link" :class="{ selected: active === item.key }" :href="item.href">
        <span><UiIcon :name="item.icon" class="ui-icon" /></span>
        {{ item.label }}
        <i v-if="item.key === 'courses' && courseCount !== null">{{ courseCount }}</i>
        <i v-else-if="item.key === 'assignments' && assignmentCount" class="side-ping">{{ assignmentCount }}</i>
        <i v-else-if="item.key === 'notifications' && notificationCount" class="side-ping">{{ notificationCount > 9 ? '9+' : notificationCount }}</i>
      </Link>
    </nav>

    <div class="sidebar-help">
      <span class="help-kicker">A LITTLE GUIDANCE</span>
      <b>Make room to learn.</b>
      <p>Your next class and learning steps, all in one place.</p>
      <div class="sidebar-help-actions"><Link class="schedule-help-action" :href="scheduleHref"><span>View your schedule</span><UiIcon name="arrow-up-right" :size="14" /></Link><Link class="contact-help-action" :href="contact().url">Need a hand? Contact us</Link></div>
    </div>

    <div class="user-profile">
      <span class="profile-avatar">{{ initials }}</span>
      <span class="user-profile-copy"><b>{{ name }}</b><small>Curious learner</small><Link class="profile-settings-link" :href="showProfile().url">Profile settings <UiIcon name="arrow-up-right" :size="12" /></Link></span>
    </div>
  </aside>
</template>
