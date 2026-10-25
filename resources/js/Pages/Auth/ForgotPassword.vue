<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { home } from '../../actions/App/Http/Controllers/PublicController';
import { showLogin, sendPasswordResetLink } from '../../actions/App/Http/Controllers/AuthController';

const form = useForm({ email: '' });
const submit = () => form.post(sendPasswordResetLink().url);
</script>

<template>
  <Head title="Reset your password — Kanram Academy" />
  <main class="auth-shell auth-v2 auth-recovery">
    <section class="auth-panel">
      <Link :href="home().url" class="brand auth-brand"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link>
      <div class="auth-copy"><div class="eyebrow">ACCOUNT RECOVERY</div><h1>Let’s get you<br><em>back in.</em></h1><p>Enter the email on your account. If it matches, we’ll send a secure link to reset your password.</p></div>
      <form class="auth-form" @submit.prevent="submit">
        <label for="recovery-email">Email address<input id="recovery-email" v-model="form.email" type="email" autocomplete="email" required placeholder="you@example.com" :aria-invalid="!!form.errors.email"><small v-if="form.errors.email" role="alert">{{ form.errors.email }}</small></label>
        <p v-if="$page.props.flash?.success" class="auth-success" role="status">{{ $page.props.flash.success }}</p>
        <button class="button button-dark auth-submit" :disabled="form.processing">{{ form.processing ? 'Sending…' : 'Send password reset link' }} <UiIcon name="arrow-up-right" :size="15" /></button>
        <p class="auth-switch"><Link :href="showLogin().url">Back to sign in</Link></p>
      </form>
      <p class="auth-privacy">For your security, we only show the same confirmation whether or not the email is registered.</p>
    </section>
    <aside class="auth-aside auth-photo-panel" aria-label="Kanram Academy account support">
      <img class="auth-aside-image" :src="'/images/learning/live-class.png'" alt="Learners collaborating in a live class" />
      <div class="auth-aside-content"><span>YOUR LEARNING IS STILL HERE</span><blockquote>Pick up where you left off, with your cohort and mentors.</blockquote><div class="auth-aside-foot"><small>Kanram Academy</small><small>Account support</small></div></div>
    </aside>
  </main>
</template>