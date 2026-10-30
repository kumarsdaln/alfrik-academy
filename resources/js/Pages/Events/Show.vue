<script setup>
import { index as wayfinderIndex1, register as wayfinderRegister3 } from './../../actions/App/Http/Controllers/WebinarEventController';
import { contact as wayfinderContact2 } from './../../actions/App/Http/Controllers/PublicController';

import { showLogin, showRegistration } from '../../actions/App/Http/Controllers/AuthController';
import { show as eventShowRoute } from '../../actions/App/Http/Controllers/WebinarEventController';
import { useForm, Link, usePage } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import ShareButton from '../../Components/ShareButton.vue';

const props = defineProps({ event: Object });
const page = usePage();
const registration = useForm({ company: '', question: '' });
const dateLabel = new Intl.DateTimeFormat(undefined, { timeZone: props.event.timezone, weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }).format(new Date(props.event.starts_at));
const timeLabel = new Intl.DateTimeFormat(undefined, { timeZone: props.event.timezone, hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }).format(new Date(props.event.starts_at));
const ticketPrice = new Intl.NumberFormat(undefined, { style: 'currency', currency: props.event.currency }).format(props.event.price_minor / 100);
</script>

<template><PublicLayout><main class="event-detail-page"><div class="wrap event-detail-wrap"><nav class="event-breadcrumbs" aria-label="Breadcrumb"><Link :href="wayfinderIndex1().url">Webinars & events</Link><span aria-hidden="true">/</span><span aria-current="page">{{ event.title }}</span></nav><div class="event-detail-grid"><article class="event-detail-main"><div class="event-detail-cover"><img :src="event.cover_image || '/images/learning/live-class.png'" :alt="event.title"><span>{{ event.event_type.replace('_', ' ') }}</span></div><div class="eyebrow event-detail-kicker">OPEN TO THE ALFRIK COMMUNITY</div><h1>{{ event.title }}</h1><p class="event-detail-summary">{{ event.summary }}</p><ShareButton :title="event.title" :text="event.summary" class="event-share-button" /><div class="event-facts"><div><UiIcon name="calendar" :size="17"/><span><small>DATE</small><b>{{ dateLabel }}</b></span></div><div><UiIcon name="clock" :size="17"/><span><small>TIME · {{ event.timezone }}</small><b>{{ timeLabel }} · {{ event.duration_minutes }} minutes</b></span></div><div><UiIcon name="users" :size="17"/><span><small>HOST</small><b>{{ event.host_name }}<small v-if="event.host_title"> · {{ event.host_title }}</small></b></span></div><div><UiIcon name="ticket" :size="17"/><span><small>ADMISSION</small><b>{{ event.price_minor > 0 ? ticketPrice : 'Free' }}</b></span></div></div><section class="event-description"><h2>What we’ll explore</h2><p>{{ event.description }}</p></section><div v-if="event.meeting_url" class="event-join-box"><span class="eyebrow">YOUR PLACE IS RESERVED</span><h2>Join the live room.</h2><p>Use this link at the scheduled time. We recommend joining a few minutes early.</p><a :href="event.meeting_url" class="button button-dark" target="_blank" rel="noopener noreferrer">Join webinar <UiIcon name="arrow-up-right" :size="13"/></a></div><div v-else-if="event.registration_state === 'waitlisted'" class="event-waitlist-box"><h2>You’re on the waitlist.</h2><p>If a place opens, the academy team will be in touch.</p></div><div v-if="event.replay_url" class="event-replay"><h2>Watch the replay</h2><a :href="event.replay_url" target="_blank" rel="noopener noreferrer">Open the session recording <UiIcon name="arrow-up-right" :size="13"/></a></div></article>
  <aside class="event-register-card"><template v-if="event.registration_state === 'registered' || event.registration_state === 'attended'"><div class="event-confirm-icon"><UiIcon name="check-circle" :size="23"/></div><span class="eyebrow">YOU’RE ON THE LIST</span><h2>See you there.</h2><p>Your place is reserved. Keep this page handy to join the live class.</p><a v-if="event.meeting_url" :href="event.meeting_url" target="_blank" rel="noopener noreferrer" class="button button-dark">Join the live room <UiIcon name="arrow-up-right" :size="13"/></a><div v-else class="event-seat-note">The host will add the live room link here before the event.</div><div class="event-seat-note"><UiIcon name="users" :size="14"/> {{ event.registered_count }} {{ event.capacity ? `of ${event.capacity}` : '' }} seats reserved</div><div v-if="event.payment_status === 'paid'" class="event-payment-note">Ticket paid · {{ ticketPrice }}</div><div v-else-if="event.payment_status === 'bypassed'" class="event-payment-note">Development preview · payment skipped</div></template>
    <template v-else-if="event.registration_state === 'waitlisted'"><span class="eyebrow">WAITLIST</span><h2>Thanks for your interest.</h2><p>We’ve saved your place on the waitlist and will be in touch if a seat opens.</p></template>
    <template v-else-if="event.registration_state === 'cancelled'"><span class="eyebrow">REGISTRATION CANCELLED</span><h2>Your ticket is no longer active.</h2><p v-if="event.payment_status === 'refunded'">Your payment was refunded. Contact the academy if you have questions.</p><p v-else>Your registration was cancelled. Contact the academy if you believe this is a mistake.</p><Link :href="wayfinderContact2().url" class="event-signup-link">Contact Alfrik Academy</Link></template>
    <template v-else-if="event.registration_state === 'pending_payment'"><span class="eyebrow">{{ event.checkout_returned ? 'PAYMENT CONFIRMATION' : 'PAYMENT IN PROGRESS' }}</span><h2>{{ event.checkout_returned ? 'Confirming your ticket.' : 'Finish saving your seat.' }}</h2><p>Your ticket is {{ ticketPrice }}. Stripe will confirm your payment before the live room becomes available.</p><a v-if="event.checkout_url && !event.checkout_returned" :href="event.checkout_url" class="button button-dark">Continue to secure checkout <UiIcon name="arrow-up-right" :size="13"/></a><p v-else class="event-payment-note">Payment confirmation is processing. Refresh this page shortly.</p></template>
    <template v-else-if="event.is_upcoming && !page.props.auth?.user"><span class="eyebrow">{{ event.price_minor > 0 ? 'TICKETS' : 'SAVE YOUR SEAT' }}</span><h2>Join us live.</h2><p>Sign in to reserve your place. Your name and email will be taken from your Alfrik account.</p><div v-if="event.capacity" class="event-seat-note"><UiIcon name="users" :size="14"/> {{ Math.max(0, event.capacity - event.registered_count) }} seats left</div><div class="event-auth-actions"><Link :href="showLogin.url({query: {next: eventShowRoute({event: event.slug}).url}})" class="button button-dark">Log in to join <UiIcon name="arrow-up-right" :size="13"/></Link><Link :href="showRegistration.url({query: {next: eventShowRoute({event: event.slug}).url}})" class="event-signup-link">Create an account</Link></div><small class="event-privacy-note">{{ event.price_minor > 0 && event.development_payment_bypass ? 'Local development preview · payment skipped' : (event.price_minor > 0 ? `Secure ticket checkout · ${ticketPrice}` : 'Free registration · no payment required') }}</small></template>
    <template v-else-if="event.is_upcoming"><span class="eyebrow">{{ event.price_minor > 0 ? 'TICKET · '+ticketPrice : 'SAVE YOUR SEAT' }}</span><h2>Join us live.</h2><p>Signed in as {{ event.attendee_name }}. Bring a question, meet a working mentor, and take away something useful.</p><div v-if="event.capacity" class="event-seat-note"><UiIcon name="users" :size="14"/> {{ Math.max(0, event.capacity - event.registered_count) }} seats left</div><form class="event-register-form" @submit.prevent="registration.post(wayfinderRegister3.url({ event: event.slug }))"><label>Company or role <span>optional</span><input v-model="registration.company" maxlength="180"></label><label>What would you like to ask? <span>optional</span><textarea v-model="registration.question" rows="3" maxlength="1500"></textarea></label><small v-if="registration.errors.payment" class="event-form-error">{{ registration.errors.payment }}</small><button class="button button-dark" :disabled="registration.processing">{{ registration.processing ? 'Preparing…' : event.price_minor > 0 ? (event.development_payment_bypass ? 'Reserve demo seat · payment skipped' : `Continue to payment · ${ticketPrice}`) : 'Reserve my place' }} <UiIcon name="arrow-up-right" :size="13"/></button><small class="event-privacy-note">{{ event.price_minor > 0 && event.development_payment_bypass ? 'Development mode skips the payment gateway for this preview.' : (event.price_minor > 0 ? 'Your seat is confirmed after Stripe verifies payment.' : 'Free registration · your account details are used for the attendee list.') }}</small></form></template>
    <template v-else><span class="eyebrow">SESSION COMPLETE</span><h2>Thanks for joining us.</h2><p>This webinar has finished. Browse upcoming conversations and workshops.</p><Link :href="wayfinderIndex1().url" class="button button-dark">See upcoming events <UiIcon name="arrow-up-right" :size="13"/></Link></template></aside></div></div></main></PublicLayout></template>

<style scoped>
.event-detail-page{min-height:80vh;padding:30px 0 88px;background:var(--academy-paper,var(--academy-paper));color:var(--academy-ink,var(--academy-ink))}
.event-detail-wrap{max-width:1160px}
.event-breadcrumbs{display:flex;align-items:center;gap:10px;min-width:0;color:var(--academy-muted);font-size:.8rem}.event-breadcrumbs a{flex:none;color:var(--academy-secondary);text-decoration:none}.event-breadcrumbs a:hover{text-decoration:underline;text-underline-offset:4px}.event-breadcrumbs>span[aria-current="page"]{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}

.event-detail-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;align-items:start;gap:clamp(38px,6vw,78px);margin-top:24px}
.event-detail-main{min-width:0}
.event-detail-cover{position:relative;height:clamp(280px,36vw,420px);overflow:hidden;background:var(--academy-paper)}
.event-detail-cover img{display:block;width:100%;height:100%;object-fit:cover}
.event-detail-cover>span{position:absolute;left:16px;bottom:16px;display:flex;align-items:center;gap:8px;padding:10px 12px;background:var(--academy-paper);color:var(--academy-secondary);font-size:.72rem;font-weight:600;letter-spacing:.06em;text-transform:capitalize}
.event-detail-kicker{margin-top:28px;color:var(--academy-secondary)}
.event-detail-main h1{margin:11px 0 12px;color:var(--academy-ink);font:450 clamp(2.7rem,5.4vw,4.75rem)/1.02 var(--serif);letter-spacing:-.05em}
.event-detail-summary{max-width:740px;margin:0;color:var(--academy-muted);font-size:clamp(1.02rem,1.7vw,1.18rem);line-height:1.7}
.event-share-button{margin-top:18px}
.event-share-button :deep(.share-button){min-height:40px;padding:8px 0;border:0;background:transparent;color:var(--academy-primary);font-size:.78rem}
.event-share-button :deep(.share-button:hover){background:transparent;text-decoration:underline;text-underline-offset:4px}
.event-facts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));margin-top:25px;border-top:1px solid #e5e3dc;border-bottom:1px solid #e5e3dc}
.event-facts>div{display:flex;align-items:flex-start;gap:12px;padding:17px 14px 17px 0;color:var(--academy-secondary)}
.event-facts>div:nth-child(even){padding-left:14px;border-left:1px solid #e5e3dc}
.event-facts>div:nth-child(n+3){border-top:1px solid #e5e3dc}
.event-facts>div>svg{flex:none;margin-top:2px}
.event-facts>div>span{display:grid;min-width:0;gap:6px}
.event-facts small{color:var(--academy-muted);font-size:.68rem;letter-spacing:.07em}
.event-facts b{color:var(--academy-ink);font-size:.88rem;font-weight:600;line-height:1.45}
.event-facts b small{display:inline;color:var(--academy-muted);font-size:.78rem;letter-spacing:normal;font-weight:400}
.event-description{padding:30px 0 28px}
.event-description h2,.event-join-box h2,.event-waitlist-box h2,.event-replay h2{margin:0 0 12px;color:var(--academy-ink);font:450 clamp(1.65rem,3vw,2rem)/1.2 var(--serif);letter-spacing:-.025em}
.event-description p{margin:0;color:var(--academy-muted);font-size:1rem;line-height:1.8;white-space:pre-line}
.event-register-card{position:sticky;top:24px;padding:26px;background:var(--academy-surface);border:1px solid #e3e3da;border-top:3px solid var(--academy-primary)}
.event-register-card>.eyebrow{color:var(--academy-secondary);font-size:.68rem}
.event-register-card h2{margin:11px 0 8px;color:var(--academy-ink);font:450 1.85rem/1.15 var(--serif);letter-spacing:-.03em}
.event-register-card>p{margin:0 0 18px;color:var(--academy-muted);font-size:.9rem;line-height:1.65}
.event-seat-note{display:flex;align-items:center;gap:8px;margin:14px 0;color:var(--academy-muted);font-size:.78rem;line-height:1.5}
.event-register-form{display:grid;gap:13px;margin-top:17px}
.event-register-form label{display:grid;gap:7px;color:var(--academy-ink);font-size:.82rem;font-weight:600}
.event-register-form label>span{display:inline;color:var(--academy-muted);font-size:.76rem;font-weight:400}
.event-register-form input,.event-register-form textarea{width:100%;padding:11px 12px;border:1px solid #dedfd7;border-radius:0;background:var(--academy-surface);color:var(--academy-ink);font:400 .9rem/1.5 var(--sans)}
.event-register-form textarea{resize:vertical}
.event-register-form :is(input,textarea):focus{outline:2px solid var(--academy-secondary-light);outline-offset:1px;border-color:var(--academy-focus)}
.event-form-error{color:var(--academy-danger);font-size:.8rem}
.event-register-form .button,.event-register-card>.button,.event-auth-actions .button{display:flex;width:100%;min-height:48px;align-items:center;justify-content:center;gap:9px;border:0;cursor:pointer;text-align:center}
.event-register-form .button:disabled{opacity:.65;cursor:wait}
.event-auth-actions{display:grid;gap:13px;margin:18px 0}
.event-signup-link{display:inline-flex;justify-content:center;color:var(--academy-secondary);font-size:.82rem;text-decoration:underline;text-underline-offset:3px}
.event-privacy-note{display:block;margin-top:13px;color:var(--academy-muted);font-size:.72rem;line-height:1.55;text-align:left}
.event-payment-note{display:block;margin-top:13px;padding-top:13px;border-top:1px solid #e5e3dc;color:var(--academy-secondary);font-size:.82rem;line-height:1.5}
.event-confirm-icon{display:grid;place-items:center;width:42px;height:42px;margin-bottom:16px;background:var(--academy-primary-soft);color:var(--academy-secondary)}
.event-join-box,.event-waitlist-box{margin:6px 0 25px;padding:23px;background:var(--academy-primary-soft)}
.event-join-box p,.event-waitlist-box p{margin:0;color:var(--academy-muted);font-size:.9rem;line-height:1.65}
.event-join-box .button{display:inline-flex;align-items:center;gap:9px;min-height:46px;margin-top:17px}
.event-replay{padding:23px 0;border-top:1px solid #e3e4dc}
.event-replay a{display:inline-flex;align-items:center;gap:8px;color:var(--academy-primary);font-size:.86rem;text-decoration:none}
.event-replay a:hover{text-decoration:underline;text-underline-offset:4px}
@media(max-width:850px){.event-detail-grid{grid-template-columns:minmax(0,1fr) 300px;gap:30px}.event-detail-cover{height:320px}.event-register-card{padding:22px}}
@media(max-width:700px){.event-detail-page{padding:22px 0 64px}.event-detail-grid{grid-template-columns:1fr;gap:25px;margin-top:20px}.event-detail-cover{height:clamp(220px,58vw,360px)}.event-register-card{position:static}.event-description{padding:24px 0}.event-register-card{padding:22px}}
@media(max-width:520px){.event-detail-wrap{padding-left:18px;padding-right:18px}.event-detail-main h1{font-size:clamp(2.5rem,11vw,3.4rem)}.event-facts>div{gap:9px;padding:13px 9px 13px 0}.event-facts>div:nth-child(even){padding-left:9px}.event-facts small{font-size:.62rem}.event-facts b{font-size:.78rem}.event-detail-kicker{margin-top:21px}.event-register-card h2{font-size:1.65rem}}
</style>