<script setup>
import { useForm } from '@inertiajs/vue3';
import LearningSettingsLayout from '../../Components/LearningSettingsLayout.vue';
import { updateNotifications } from '../../actions/App/Http/Controllers/StudentProfileController';

const props = defineProps({ preferences: { type: Object, required: true } });
const form = useForm({ preferences: { ...props.preferences } });
const save = () => form.put(updateNotifications().url, { preserveScroll: true });
</script>

<template>
  <LearningSettingsLayout active="notifications" title="Notifications" description="Choose the in-app updates you want to see in your Alfrik learning space." eyebrow="YOUR ACCOUNT SETTINGS · PREFERENCES">
    <section class="settings-detail-grid settings-notifications-grid">
      <form class="profile-settings-card profile-notification-form settings-form-card" @submit.prevent="save">
        <div class="profile-settings-heading"><div><span class="eyebrow">IN-APP UPDATES</span><h2>What we’ll let you know about</h2></div><UiIcon name="bell" :size="20" /></div>
        <label class="profile-toggle-row"><span><b>Live class reminders</b><small>Schedule changes, class updates, and replay availability.</small></span><input v-model="form.preferences.class_reminders" type="checkbox" aria-label="Enable live class notifications"></label>
        <label class="profile-toggle-row"><span><b>Assignment feedback</b><small>Know when a mentor reviews your submitted work.</small></span><input v-model="form.preferences.assignment_feedback" type="checkbox" aria-label="Enable assignment feedback notifications"></label>
        <label class="profile-toggle-row"><span><b>Events & webinars</b><small>Registration confirmations and event updates.</small></span><input v-model="form.preferences.event_updates" type="checkbox" aria-label="Enable event notifications"></label>
        <label class="profile-toggle-row"><span><b>Academy updates</b><small>Important learning and account announcements.</small></span><input v-model="form.preferences.academy_updates" type="checkbox" aria-label="Enable academy notifications"></label>
        <div class="settings-form-actions"><span>Your choices apply to new in-app notifications.</span><button class="button button-dark" type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save preferences' }} <UiIcon name="arrow-up-right" :size="14" /></button></div>
      </form>
      <aside class="settings-note settings-note-tall"><UiIcon name="mail" :size="19" /><div><b>One useful mail</b><p>Updates you keep enabled will appear in your Notifications panel.</p></div></aside>
    </section>
  </LearningSettingsLayout>
</template>
