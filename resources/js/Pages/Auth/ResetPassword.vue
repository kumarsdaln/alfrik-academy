<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { home } from '../../actions/App/Http/Controllers/PublicController';
import { resetPassword } from '../../actions/App/Http/Controllers/AuthController';

const props = defineProps({ token: String, email: String });
const form = useForm({ token: props.token, email: props.email, password: '', password_confirmation: '' });
const submit = () => form.post(resetPassword().url);
</script>

<template>
  <Head title="Choose a new password — Kanram Academy" />
  <main class="auth-shell auth-v2 auth-recovery">
    <section class="auth-panel">
      <Link :href="home().url" class="brand auth-brand"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link>
      <div class="auth-copy"><div class="eyebrow">ACCOUNT RECOVERY</div><h1>Choose a<br><em>new password.</em></h1><p>Use at least 12 characters and keep it unique to your account.</p></div>
      <form class="auth-form" @submit.prevent="submit">
        <label for="reset-email">Email address<input id="reset-email" v-model="form.email" type="email" autocomplete="email" required :aria-invalid="!!form.errors.email"><small v-if="form.errors.email" role="alert">{{ form.errors.email }}</small></label>
        <label for="reset-password">New password<input id="reset-password" v-model="form.password" type="password" autocomplete="new-password" minlength="12" required :aria-invalid="!!form.errors.password"><small v-if="form.errors.password" role="alert">{{ form.errors.password }}</small></label>
        <label for="reset-confirmation">Confirm new password<input id="reset-confirmation" v-model="form.password_confirmation" type="password" autocomplete="new-password" minlength="12" required></label>
        <button class="button button-dark auth-submit" :disabled="form.processing">{{ form.processing ? 'Updating…' : 'Update password' }} <UiIcon name="arrow-up-right" :size="15" /></button>
        <p class="auth-switch"><Link :href="home().url">Back to Kanram Academy</Link></p>
      </form>
      <p class="auth-privacy">Reset links expire after a short time and can only be used once.</p>
    </section>
    <aside class="auth-aside auth-photo-panel" aria-label="Kanram Academy account security">
      <img class="auth-aside-image" :src="'/images/learning/live-class.png'" alt="Learners collaborating in a live class" />
      <div class="auth-aside-content"><span>A SAFER WAY BACK</span><blockquote>Your learning space and progress will be here when you return.</blockquote><div class="auth-aside-foot"><small>Kanram Academy</small><small>Account security</small></div></div>
    </aside>
  </main>
</template>