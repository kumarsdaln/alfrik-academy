<script setup>
import { home as wayfinderHome1 } from './../../actions/App/Http/Controllers/PublicController';
import { showRegistration as wayfinderShowRegistration2 } from './../../actions/App/Http/Controllers/AuthController';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { login as loginAction } from '../../actions/App/Http/Controllers/AuthController';
import { showForgotPassword as passwordRequest } from '../../actions/App/Http/Controllers/AuthController';

const form = useForm({ email: '', password: '', remember: true });
const submit = () => form.post(loginAction().url);
</script>

<template>
  <Head title="Log in — Alfrik Academy" />
  <main class="auth-shell auth-v2 auth-login">
    <section class="auth-panel">
      <Link :href="wayfinderHome1().url" class="brand auth-brand"><BrandMark class="brand-mark" /><span>Alfrik Academy</span></Link>
      <div class="auth-copy"><div class="eyebrow">YOUR NEXT CLASS IS CLOSER</div><h1>Welcome<br>back.</h1><p>Sign in to reconnect with your cohort, mentor, and next live session.</p></div>
      <p v-if="$page.props.flash?.success" class="auth-success" role="status">{{ $page.props.flash.success }}</p>
      <form class="auth-form" @submit.prevent="submit">
        <label for="login-email">Email address<input id="login-email" v-model="form.email" type="email" autocomplete="email" required placeholder="you@example.com" :aria-invalid="!!form.errors.email"><small v-if="form.errors.email" role="alert">{{ form.errors.email }}</small></label>
        <label for="login-password">Password<input id="login-password" v-model="form.password" type="password" autocomplete="current-password" required placeholder="Enter your password" :aria-invalid="!!form.errors.password"><small v-if="form.errors.password" role="alert">{{ form.errors.password }}</small></label>
        <div class="auth-options"><label class="remember-row"><input v-model="form.remember" type="checkbox"> <span>Keep me signed in</span></label><Link class="auth-forgot-link" :href="passwordRequest().url">Forgot password?</Link></div>
        <button class="button button-dark auth-submit" :disabled="form.processing">{{ form.processing ? 'Signing in…' : 'Log in to your learning space' }} <UiIcon name="arrow-up-right" class="ui-icon" :size="15" /></button>
        <p class="auth-switch">New to Alfrik Academy? <Link :href="wayfinderShowRegistration2().url">Create an account</Link></p>
      </form>
      <p class="auth-privacy">Your learning space is private and secure.</p>
    </section>
    <aside class="auth-aside auth-photo-panel" aria-label="Learn together at Alfrik Academy">
      <img class="auth-aside-image" :src="'/images/learning/live-class.png'" alt="Learners collaborating in a live class" />
      <div class="auth-aside-content"><span>LEARN TOGETHER, GO FURTHER</span><blockquote>“The best thing I learned was how much I could do with the right people in my corner.”</blockquote><div class="auth-aside-foot"><small>Jordan Lee</small><small>Product Design Cohort</small></div></div>
    </aside>
  </main>
</template>