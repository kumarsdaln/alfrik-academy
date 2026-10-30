<script setup>
import { home as wayfinderHome1 } from './../../actions/App/Http/Controllers/PublicController';
import { showLogin as wayfinderShowLogin2 } from './../../actions/App/Http/Controllers/AuthController';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { register as registerAction } from '../../actions/App/Http/Controllers/AuthController';

const form = useForm({ name: '', email: '', timezone: 'Asia/Kolkata', password: '', password_confirmation: '' });
const submit = () => form.post(registerAction().url);
</script>

<template>
  <Head title="Create your account — Alfrik Academy" />
  <main class="auth-shell auth-v2 auth-register">
    <section class="auth-panel">
      <Link :href="wayfinderHome1().url" class="brand auth-brand"><BrandMark class="brand-mark" /><span>Alfrik Academy</span></Link>
      <div class="auth-copy"><div class="eyebrow">COME LEARN WITH US</div><h1>Make room<br>for <em>what’s next.</em></h1><p>One account brings your live classes, mentors, and learning progress together.</p></div>
      <form class="auth-form" @submit.prevent="submit">
        <label for="register-name">Your name<input id="register-name" v-model="form.name" autocomplete="name" required placeholder="Alex Morgan" :aria-invalid="!!form.errors.name"><small v-if="form.errors.name" role="alert">{{ form.errors.name }}</small></label>
        <label for="register-email">Email address<input id="register-email" v-model="form.email" type="email" autocomplete="email" required placeholder="you@example.com" :aria-invalid="!!form.errors.email"><small v-if="form.errors.email" role="alert">{{ form.errors.email }}</small></label>
        <label for="register-timezone">Your timezone<select id="register-timezone" v-model="form.timezone" autocomplete="timezone"><option value="Asia/Kolkata">India Standard Time (IST)</option><option value="America/New_York">Eastern Time (ET)</option><option value="America/Los_Angeles">Pacific Time (PT)</option><option value="Europe/London">United Kingdom (GMT/BST)</option><option value="UTC">UTC</option></select><small v-if="form.errors.timezone" role="alert">{{ form.errors.timezone }}</small></label>
        <div class="auth-password-row"><label for="register-password">Password<input id="register-password" v-model="form.password" type="password" autocomplete="new-password" minlength="12" required placeholder="At least 12 characters" :aria-invalid="!!form.errors.password"><small v-if="form.errors.password" role="alert">{{ form.errors.password }}</small></label><label for="register-password-confirmation">Confirm password<input id="register-password-confirmation" v-model="form.password_confirmation" type="password" autocomplete="new-password" minlength="12" required placeholder="Repeat password"></label></div>
        <button class="button button-dark auth-submit" :disabled="form.processing">{{ form.processing ? 'Creating account…' : 'Create your learner account' }} <UiIcon name="arrow-up-right" class="ui-icon" :size="15" /></button>
        <p class="auth-switch">Already have an account? <Link :href="wayfinderShowLogin2().url">Log in</Link></p>
      </form>
      <p class="auth-privacy">By creating an account, you agree to use Alfrik Academy respectfully.</p>
    </section>
    <aside class="auth-aside auth-photo-panel" aria-label="Learn together at Alfrik Academy">
      <img class="auth-aside-image" :src="'/images/learning/live-class.png'" alt="Learners collaborating in a live class" />
      <div class="auth-aside-content"><span>GOOD THINGS HAPPEN LIVE</span><blockquote>“I came for the skills. I stayed for the people who challenged and cheered me on.”</blockquote><div class="auth-aside-foot"><small>Alfrik Academy</small><small>Learning, together</small></div></div>
    </aside>
  </main>
</template>