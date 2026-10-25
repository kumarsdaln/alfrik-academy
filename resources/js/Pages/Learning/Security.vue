<script setup>
import { useForm } from '@inertiajs/vue3';
import LearningSettingsLayout from '../../Components/LearningSettingsLayout.vue';
import { updatePassword } from '../../actions/App/Http/Controllers/StudentProfileController';

const props = defineProps({ security: { type: Object, required: true } });
const form = useForm({ current_password: '', password: '', password_confirmation: '' });
const changePassword = () => form.put(updatePassword().url, { preserveScroll: true, onSuccess: () => form.reset() });
</script>

<template>
  <LearningSettingsLayout active="security" title="Security" description="Protect your account and keep access to your learning space secure." eyebrow="YOUR ACCOUNT SETTINGS · PROTECTION">
    <section class="settings-detail-grid settings-security-grid">
      <form class="profile-settings-card profile-password-form settings-form-card" @submit.prevent="changePassword">
        <div class="profile-settings-heading"><div><span class="eyebrow">PASSWORD</span><h2>Change your password</h2></div><UiIcon name="lock-keyhole" :size="20" /></div>
        <p class="settings-card-intro">Choose a password you don’t use on other websites.</p>
        <label for="current-password">Current password<input id="current-password" v-model="form.current_password" type="password" autocomplete="current-password" required :aria-invalid="!!form.errors.current_password"><small v-if="form.errors.current_password" role="alert">{{ form.errors.current_password }}</small></label>
        <div class="profile-password-fields"><label for="new-password">New password<input id="new-password" v-model="form.password" type="password" autocomplete="new-password" required :aria-invalid="!!form.errors.password"><small>At least 12 characters with uppercase, lowercase, and a number.</small><small v-if="form.errors.password" role="alert">{{ form.errors.password }}</small></label><label for="confirm-password">Confirm new password<input id="confirm-password" v-model="form.password_confirmation" type="password" autocomplete="new-password" required></label></div>
        <div class="settings-form-actions"><span>Your current password confirms this change.</span><button class="button button-dark" type="submit" :disabled="form.processing">{{ form.processing ? 'Updating…' : 'Update password' }} <UiIcon name="arrow-up-right" :size="14" /></button></div>
      </form>
      <aside class="profile-settings-aside">
        <section class="profile-settings-card profile-security-card"><span class="eyebrow">ACCOUNT EMAIL</span><h2>{{ security.emailVerified ? 'Verified and ready' : 'Verification pending' }}</h2><p>{{ security.email }}</p><span class="profile-email-status" :class="security.emailVerified ? 'is-verified' : 'is-pending'"><UiIcon :name="security.emailVerified ? 'check-circle' : 'help'" :size="15" />{{ security.emailVerified ? 'Email verified' : 'Needs verification' }}</span></section>
        <section class="settings-security-tip"><UiIcon name="lock-keyhole" :size="19" /><div><b>Keep your account safe</b><p>Never share your password. Kanram staff will never ask you for it.</p></div></section>
      </aside>
    </section>
  </LearningSettingsLayout>
</template>
