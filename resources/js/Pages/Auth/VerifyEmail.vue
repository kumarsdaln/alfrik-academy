<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { home } from '../../actions/App/Http/Controllers/PublicController';
import { resendVerification, logout } from '../../actions/App/Http/Controllers/AuthController';

const form = useForm({});
const resend = () => form.post(resendVerification().url);
</script>

<template>
  <Head title="Verify your email — Alfrik Academy" />
  <main class="auth-shell auth-v2 auth-recovery">
    <section class="auth-panel">
      <Link :href="home().url" class="brand auth-brand"><BrandMark class="brand-mark" /><span>Alfrik Academy</span></Link>
      <div class="auth-copy"><div class="eyebrow">ONE QUICK ACCOUNT CHECK</div><h1>Check your<br><em>inbox.</em></h1><p>We sent a secure verification link to <strong>{{ $page.props.auth?.user?.email }}</strong>. Verify your address to open your learning space.</p></div>
      <form class="auth-form" @submit.prevent="resend">
        <p v-if="$page.props.flash?.success" class="auth-success" role="status">{{ $page.props.flash.success }}</p>
        <button class="button button-dark auth-submit" :disabled="form.processing">{{ form.processing ? 'Sending…' : 'Send a fresh link' }} <UiIcon name="arrow-up-right" :size="15" /></button>
        <p class="auth-switch"><Link :href="logout().url" method="post" as="button">Sign out and use another account</Link></p>
      </form>
      <p class="auth-privacy">Email verification helps protect your learning history and class updates.</p>
    </section>
    <aside class="auth-aside auth-photo-panel" aria-label="Alfrik Academy account security">
      <img class="auth-aside-image" :src="'/images/learning/live-class.png'" alt="Learners collaborating in a live class" />
      <div class="auth-aside-content"><span>KEEP YOUR ACCOUNT SECURE</span><blockquote>One quick check keeps your learning space connected to you.</blockquote><div class="auth-aside-foot"><small>Alfrik Academy</small><small>Account security</small></div></div>
    </aside>
  </main>
</template>