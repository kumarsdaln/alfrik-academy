<script setup>
import { apply as wayfinderApply1, jobs as wayfinderJobs2 } from './../../actions/App/Http/Controllers/DiscoveryController';
import { showLogin as wayfinderShowLogin3 } from './../../actions/App/Http/Controllers/AuthController';

import { Link, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import ShareButton from '../../Components/ShareButton.vue';

const props = defineProps({ job: Object, hasApplied: Boolean });
const page = usePage();
const form = useForm({ cover_note: '' });
function apply() { form.post(wayfinderApply1.url({ slug: props.job.slug })); }
</script>
<template>
  <PublicLayout>
    <main class="career-page">
      <article class="job-detail wrap">
        <Link :href="wayfinderJobs2().url" class="back-link"><UiIcon name="arrow-left" :size="15" /> All opportunities</Link>

        <header class="job-hero">
          <div class="job-company-mark" aria-hidden="true">{{ job.company.slice(0, 1).toUpperCase() }}</div>
          <div class="job-heading-copy">
            <div class="eyebrow">{{ job.company }} <span aria-hidden="true">·</span> {{ job.location }}</div>
            <h1>{{ job.title }}</h1>
            <p class="job-summary">{{ job.summary }}</p>
            <div class="job-tags">
              <span>{{ job.workplace_type.replace('_', ' ') }}</span>
              <span>{{ job.employment_type.replace('_', ' ') }}</span>
              <span v-if="job.seniority">{{ job.seniority }}</span>
            </div>
          </div>
          <ShareButton :title="job.title + ' at ' + job.company" :text="job.summary" />
        </header>

        <div class="job-layout">
          <div class="job-content">
            <section v-if="job.skills?.length" class="job-section job-skills">
              <div class="eyebrow">WHAT YOU’LL BRING</div>
              <h2>Skills that help</h2>
              <div class="job-skill-list"><span v-for="skill in job.skills" :key="skill">{{ skill }}</span></div>
            </section>
            <section class="job-section job-description">
              <div class="eyebrow">THE ROLE</div>
              <h2>About the opportunity</h2>
              <p>{{ job.description }}</p>
            </section>
            <p class="job-disclaimer">Listings are shared by the Alfrik community. Review the employer and role details before applying.</p>
          </div>

          <aside class="job-apply-box">
            <div class="eyebrow">NEXT STEP</div>
            <template v-if="job.application_url">
              <h2>Ready to take a closer look?</h2>
              <p>You’ll continue to {{ job.company }}’s application page to learn more and apply.</p>
              <a :href="job.application_url" target="_blank" rel="noopener noreferrer" class="button button-dark">Apply with {{ job.company }} <UiIcon name="arrow-up-right" :size="14" /></a>
              <small class="apply-note">Applications are handled by the employer.</small>
            </template>
            <template v-else-if="hasApplied">
              <h2>Application received</h2>
              <p>You’ve expressed interest in this opportunity. The community poster can follow up with you.</p>
            </template>
            <template v-else-if="page.props.auth?.user">
              <h2>Interested in this role?</h2>
              <p>Introduce yourself to the opportunity poster. Your account profile will be shared with the team.</p>
              <form @submit.prevent="apply">
                <label for="cover_note">A short note <span>(optional)</span></label>
                <textarea id="cover_note" v-model="form.cover_note" rows="5" maxlength="5000" placeholder="Tell them what interests you about this opportunity."></textarea>
                <small v-if="form.errors.cover_note" class="field-error">{{ form.errors.cover_note }}</small>
                <button class="button button-dark" :disabled="form.processing">{{ form.processing ? 'Sending…' : 'Express interest' }} <UiIcon name="arrow-up-right" :size="14" /></button>
              </form>
            </template>
            <template v-else>
              <h2>Interested in this role?</h2>
              <p>Sign in to introduce yourself to the opportunity poster.</p>
              <Link class="button button-dark" :href="wayfinderShowLogin3().url">Sign in to apply <UiIcon name="arrow-up-right" :size="14" /></Link>
            </template>
            <div v-if="job.salary_range" class="job-salary"><span>Compensation</span><strong>{{ job.salary_range }}</strong></div>
          </aside>
        </div>
      </article>
    </main>
  </PublicLayout>
</template>

<style scoped>
.career-page{min-height:80vh;padding:38px 0 88px;background:var(--academy-paper,var(--academy-paper));color:var(--academy-ink,var(--academy-ink))}
.job-detail{max-width:1120px}
.back-link{display:inline-flex;align-items:center;gap:8px;margin:0 0 28px;color:var(--academy-secondary);font-size:.88rem;text-decoration:none}
.back-link:hover{text-decoration:underline;text-underline-offset:4px}
.job-hero{display:grid;grid-template-columns:64px minmax(0,1fr) auto;align-items:start;gap:20px;padding:34px 0 36px;border-top:1px solid #e5e3dc;border-bottom:1px solid #e5e3dc}
.job-company-mark{display:grid;place-items:center;width:62px;height:62px;background:var(--academy-primary-soft);color:var(--academy-secondary);font:500 1.55rem var(--serif)}
.job-heading-copy{min-width:0}
.job-heading-copy .eyebrow{color:var(--academy-muted)}
.job-heading-copy h1{margin:10px 0 12px;color:var(--academy-ink);font:450 clamp(2.7rem,5.4vw,4.5rem)/1.02 var(--serif);letter-spacing:-.045em}
.job-summary{max-width:760px;margin:0;color:var(--academy-muted);font-size:1.08rem;line-height:1.7}
.job-hero :deep(.share-button),.job-hero :deep(button){align-self:start}
.job-tags,.job-skill-list{display:flex;flex-wrap:wrap;gap:8px}
.job-tags{margin-top:19px}
.job-tags span,.job-skill-list span{padding:7px 10px;background:var(--academy-paper);color:var(--academy-secondary);font-size:.8rem;text-transform:capitalize}
.job-layout{display:grid;grid-template-columns:minmax(0,1fr) 340px;align-items:start;gap:clamp(40px,7vw,96px);padding-top:38px}
.job-content{min-width:0}
.job-section{padding:0 0 32px;border-bottom:1px solid #e5e3dc}
.job-section+.job-section{padding-top:30px}
.job-section h2,.job-apply-box h2{margin:8px 0 14px;color:var(--academy-ink);font:450 1.85rem/1.2 var(--serif);letter-spacing:-.02em}
.job-description p{margin:0;color:var(--academy-muted);font-size:1rem;line-height:1.85;white-space:pre-line}
.job-skill-list{margin-top:18px}
.job-skill-list span{background:var(--academy-surface);border:1px solid #e2e5dc}
.job-apply-box{position:sticky;top:24px;padding:25px;background:var(--academy-surface);border:1px solid #e3e3da;border-top:3px solid var(--academy-primary)}
.job-apply-box h2{font-size:1.65rem}
.job-apply-box p,.apply-note{display:block;margin:0 0 19px;color:var(--academy-muted);font-size:.9rem;line-height:1.65}
.job-apply-box .button{display:flex;width:100%;min-height:48px;align-items:center;justify-content:center;gap:10px;text-align:center}
.job-apply-box form{display:grid;gap:10px}
.job-apply-box label{color:var(--academy-ink);font-size:.88rem;font-weight:600}
.job-apply-box label span{color:var(--academy-muted);font-weight:400}
.job-apply-box textarea{width:100%;padding:12px;border:1px solid #dedfd7;border-radius:0;background:var(--academy-surface);color:var(--academy-ink);font:400 .94rem/1.5 var(--sans);resize:vertical}
.job-apply-box textarea:focus{outline:2px solid var(--academy-secondary-light);outline-offset:1px;border-color:var(--academy-focus)}
.job-apply-box form .button{margin-top:4px;cursor:pointer}
.job-apply-box form .button:disabled{opacity:.6;cursor:wait}
.job-salary{display:flex;flex-direction:column;gap:5px;margin-top:22px;padding-top:18px;border-top:1px solid #e9e8e1}
.job-salary span{color:var(--academy-muted);font-size:.8rem}
.job-salary strong{color:var(--academy-ink);font-size:1rem;font-weight:600}
.apply-note{margin:12px 0 0;font-size:.78rem}
.field-error{color:var(--academy-danger);font-size:.8rem}
.job-disclaimer{margin:20px 0 0;color:var(--academy-muted);font-size:.8rem;line-height:1.6}
@media(max-width:800px){.job-layout{grid-template-columns:minmax(0,1fr) 300px;gap:32px}.job-hero{grid-template-columns:54px minmax(0,1fr) auto;gap:15px}.job-company-mark{width:54px;height:54px}}
@media(max-width:650px){.career-page{padding-top:24px}.job-detail{padding-left:20px;padding-right:20px}.back-link{margin-bottom:20px}.job-hero{grid-template-columns:46px minmax(0,1fr);gap:13px;padding:24px 0 26px}.job-company-mark{width:46px;height:46px}.job-heading-copy h1{font-size:clamp(2.4rem,10vw,3.5rem)}.job-summary{font-size:.98rem}.job-hero :deep(.share-button),.job-hero :deep(button){grid-column:2;grid-row:2}.job-layout{grid-template-columns:1fr;gap:26px;padding-top:28px}.job-apply-box{position:static;grid-row:1}.job-content{grid-row:2}.job-section h2{font-size:1.65rem}}
</style>