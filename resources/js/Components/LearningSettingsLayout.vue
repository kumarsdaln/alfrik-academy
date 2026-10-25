<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import LearningSidebar from './LearningSidebar.vue';
import { dashboard } from '../actions/App/Http/Controllers/StudentLearningController';
import { show as profileRoute, learningPreferences as learningRoute, notifications as notificationsRoute, security as securityRoute } from '../actions/App/Http/Controllers/StudentProfileController';

const props = defineProps({ active: { type: String, required: true }, title: { type: String, required: true }, description: { type: String, required: true }, eyebrow: { type: String, default: 'YOUR ACCOUNT SETTINGS' } });
const page = usePage();
const links = computed(() => [
  { key: 'profile', label: 'Profile', icon: 'users', href: profileRoute().url },
  { key: 'learning', label: 'Learning preferences', icon: 'book-open', href: learningRoute().url },
  { key: 'notifications', label: 'Notifications', icon: 'bell', href: notificationsRoute().url },
  { key: 'security', label: 'Security', icon: 'lock-keyhole', href: securityRoute().url },
]);
</script>

<template>
  <Head :title="`${title} — Kanram Academy`" />
  <div class="dashboard-shell">
    <LearningSidebar active="profile" />
    <main class="dash-main">
      <header class="dash-top"><Link :href="dashboard().url"><UiIcon name="arrow-left" :size="13" /> Learning home</Link><span>Account settings</span></header>
      <div class="dash-content learner-profile-content settings-page-content">
        <div class="learner-index-heading profile-page-heading"><div><div class="eyebrow">{{ eyebrow }}</div><h1>{{ title }}</h1><p>{{ description }}</p></div></div>
        <nav class="profile-settings-nav" aria-label="Account settings">
          <Link v-for="item in links" :key="item.key" :href="item.href" :class="{ active: active === item.key }" :aria-current="active === item.key ? 'page' : undefined"><UiIcon :name="item.icon" :size="14" /><span>{{ item.label }}</span></Link>
        </nav>
        <p v-if="page.props.flash?.success" class="profile-saved profile-page-saved" role="status"><UiIcon name="check" :size="14" /> {{ page.props.flash.success }}</p>
        <slot />
      </div>
    </main>
  </div>
</template>
