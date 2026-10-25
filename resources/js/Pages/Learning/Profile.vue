<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import LearningSettingsLayout from '../../Components/LearningSettingsLayout.vue';
import { update as updateProfile } from '../../actions/App/Http/Controllers/StudentProfileController';
import { contact } from '../../actions/App/Http/Controllers/PublicController';

const props = defineProps({ profile: { type: Object, required: true } });
const form = useForm({ name: props.profile.name, bio: props.profile.bio || '' });
const save = () => form.put(updateProfile().url, { preserveScroll: true });
</script>

<template>
  <LearningSettingsLayout active="profile" title="Your profile" description="The personal details your mentors and academy team use to know you.">
    <section class="settings-detail-grid">
      <form class="profile-settings-card settings-form-card" @submit.prevent="save">
        <div class="profile-settings-heading"><div><span class="eyebrow">PERSONAL DETAILS</span><h2>Edit your profile</h2></div><span class="profile-large-avatar">{{ profile.name.split(' ').map(part => part[0]).slice(0, 2).join('').toUpperCase() }}</span></div>
        <label for="profile-name">Display name<input id="profile-name" v-model="form.name" autocomplete="name" required maxlength="120" :aria-invalid="!!form.errors.name"><small v-if="form.errors.name" role="alert">{{ form.errors.name }}</small></label>
        <label for="profile-email">Email address<input id="profile-email" :value="profile.email" type="email" disabled><small>{{ profile.emailVerified ? 'This email address is verified.' : 'This email address is awaiting verification.' }}</small></label>
        <label for="profile-bio">A little about you <span class="profile-optional">Optional</span><textarea id="profile-bio" v-model="form.bio" rows="5" maxlength="500" placeholder="What are you hoping to learn?" :aria-invalid="!!form.errors.bio"></textarea><small v-if="form.errors.bio" role="alert">{{ form.errors.bio }}</small><small>{{ form.bio.length }}/500 characters</small></label>
        <div class="settings-form-actions"><span>Keep your profile useful and up to date.</span><button class="button button-dark" type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save profile' }} <UiIcon name="arrow-up-right" :size="14" /></button></div>
      </form>
      <aside class="profile-settings-aside">
        <section class="profile-settings-card profile-security-card"><span class="eyebrow">ACCOUNT EMAIL</span><h2>{{ profile.emailVerified ? 'Verified and ready' : 'Verification pending' }}</h2><p>{{ profile.emailVerified ? 'Your verified email keeps class reminders, mentor feedback, and receipts connected to your account.' : 'Verify your email to access all learning features and keep account messages connected.' }}</p><span class="profile-email-status" :class="profile.emailVerified ? 'is-verified' : 'is-pending'"><UiIcon :name="profile.emailVerified ? 'check-circle' : 'help'" :size="15" />{{ profile.emailVerified ? 'Email verified' : 'Needs verification' }}</span></section>
        <section class="profile-help-card"><span class="eyebrow">NEED A HAND?</span><h2>We’re here to help.</h2><p>Talk to the academy team about your account.</p><Link :href="contact().url">Contact the academy <UiIcon name="arrow-up-right" :size="13" /></Link></section>
      </aside>
    </section>
  </LearningSettingsLayout>
</template>
