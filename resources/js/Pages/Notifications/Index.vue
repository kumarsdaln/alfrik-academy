<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';
import NotificationInbox from '../../Components/NotificationInbox.vue';
import StaffAdminLayout from '../../Layouts/StaffAdminLayout.vue';

defineProps({ notifications: Object, unreadCount: Number, counts: Object, activeFilter: String });
const page = usePage();
const isStaff = computed(() => (page.props.auth?.user?.roles || []).some((role) => ['admin', 'teacher', 'social_manager'].includes(role)));
</script>

<template>
  <StaffAdminLayout v-if="isStaff">
    <NotificationInbox :notifications="notifications" :unread-count="unreadCount" :counts="counts" :active-filter="activeFilter" />
  </StaffAdminLayout>
  <div v-else class="dashboard-shell">
    <LearningSidebar active="notifications" />
    <main class="dash-main">
      <header class="dash-top"><span>Your Kanram account</span></header>
      <div class="dash-content notification-page-content"><NotificationInbox :notifications="notifications" :unread-count="unreadCount" :counts="counts" :active-filter="activeFilter" /></div>
    </main>
  </div>
</template>

<style scoped>.notification-page-content{padding-top:38px}@media(max-width:680px){.notification-page-content{padding:25px 14px 42px}}</style>
