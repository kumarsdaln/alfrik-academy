<script setup>
  import { jobs as wayfinderJobs1, insights as wayfinderInsights2, job as wayfinderJob3, submitJob as wayfinderSubmitJob4 } from './../../actions/App/Http/Controllers/DiscoveryController';

  import { jobs as jobsRoute } from '../../actions/App/Http/Controllers/DiscoveryController';
  import { router, Link, useForm } from '@inertiajs/vue3';
  import { nextTick, ref, watch } from 'vue';
  import PublicLayout from '../../Layouts/PublicLayout.vue';

  const props = defineProps({ jobs: Object, filters: Object });
  const q = ref(props.filters.q || '');
  const employment = ref(props.filters.employment || '');
  const showEmployerForm = ref(false);
  const submission = useForm({ title: '', company: '', contact_name: '', contact_email: '', company_website: '', location: 'Remote', workplace_type: 'remote', employment_type: 'full_time', seniority: '', salary_range: '', summary: '', description: '', skills: '', application_url: '', expires_at: '', fax_number: '' });
  let debounce;
  watch([q, employment], () => {
    clearTimeout(debounce);
    debounce = setTimeout(() => router.get(wayfinderJobs1().url, { q: q.value, employment: employment.value }, { preserveState: true, preserveScroll: true, replace: true }), 250);
  });
  function postOpportunity() {
    submission.post(wayfinderSubmitJob4().url, { preserveScroll: true, onSuccess: () => { submission.reset(); showEmployerForm.value = false; } });
  }
  function openEmployerForm() {
    showEmployerForm.value = true;
    nextTick(() => document.getElementById('employer-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
  }
</script>

<template>
  <PublicLayout>
    <main class="career-page">
      <section class="career-hero wrap">
        <div class="career-hero-copy">
          <div class="eyebrow"><span class="career-live-dot"></span> ALFRIK CAREER BOARD</div>
          <h1>Find work that<br><em>moves you forward.</em></h1>
          <p>Explore roles shared by the Alfrik community, discover teams looking for your skills, and take the next
            step in your career.</p>
          <div class="career-hero-actions"><a href="#open-roles" class="button button-dark">Explore open roles
              <UiIcon name="arrow-right" :size="14" />
            </a>
            <Link :href="wayfinderInsights2().url" class="text-link">Read career guides
              <UiIcon name="arrow-up-right" :size="13" />
            </Link>
          </div>
        </div>
        <aside class="career-employer-card"><span class="career-employer-icon">
            <UiIcon name="briefcase" :size="20" />
          </span>
          <div class="eyebrow">HIRING?</div>
          <h2>Meet your next great hire.</h2>
          <p>Share a role with our learners and alumni. Posting is free, and every listing is reviewed by our team.</p>
          <button class="career-employer-link" type="button" @click="openEmployerForm">Post a job
            <UiIcon name="arrow-up-right" :size="14" />
          </button>
          <div class="career-employer-foot">
            <UiIcon name="check-circle" :size="14" /> Employer contact details stay private
          </div>
        </aside>
      </section>
      <section id="open-roles" class="career-board wrap">
        <div class="career-board-head">
          <div>
            <div class="eyebrow">COMMUNITY OPPORTUNITIES</div>
            <h2>Work worth growing into.</h2>
          </div>
          <div class="career-board-actions"><span>{{ jobs.total }} open roles</span><button class="button button-dark"
              type="button" @click="showEmployerForm = !showEmployerForm">{{ showEmployerForm ? 'Close form' : 'Post a job' }}
              <UiIcon :name="showEmployerForm ? 'close' : 'plus'" :size="14" />
            </button></div>
        </div>
        <form id="employer-form" v-if="showEmployerForm" class="employer-submit-form" @submit.prevent="postOpportunity">
          <div class="employer-submit-heading">
            <div>
              <div class="eyebrow">FOR EMPLOYERS</div>
              <h2>Share an opportunity.</h2>
              <p>Reach Alfrik learners and alumni. Every listing is reviewed before it appears on the board.</p>
            </div><span class="employer-submit-note">
              <UiIcon name="check-circle" :size="16" /> Your contact details stay private.
            </span>
          </div>
          <div class="employer-fields"><label>Role title<input v-model="submission.title" required maxlength="180"
                placeholder="Product designer"><small v-if="submission.errors.title">{{ submission.errors.title
                }}</small></label><label>Company<input v-model="submission.company" required maxlength="180"
                placeholder="Your company"><small v-if="submission.errors.company">{{ submission.errors.company
                }}</small></label><label>Contact name<input v-model="submission.contact_name" required maxlength="180"
                autocomplete="name" placeholder="Hiring contact"><small v-if="submission.errors.contact_name">{{
                  submission.errors.contact_name }}</small></label><label>Work email<input
                v-model="submission.contact_email" required type="email" maxlength="254" autocomplete="email"
                placeholder="you@company.com"><small v-if="submission.errors.contact_email">{{
                  submission.errors.contact_email }}</small></label><label>Company website <span
                class="optional-field">Optional</span><input v-model="submission.company_website" type="url"
                placeholder="https://company.com"><small v-if="submission.errors.company_website">{{
                  submission.errors.company_website }}</small></label><label>Application link <span
                class="optional-field">Optional</span><input v-model="submission.application_url" type="url"
                placeholder="https://company.com/careers/role"><small v-if="submission.errors.application_url">{{
                  submission.errors.application_url }}</small></label><label>Location<input v-model="submission.location"
                required maxlength="180" placeholder="Remote, India"><small v-if="submission.errors.location">{{
                  submission.errors.location }}</small></label><label>Work setup<select
                v-model="submission.workplace_type">
                <option value="remote">Remote</option>
                <option value="hybrid">Hybrid</option>
                <option value="on_site">On-site</option>
              </select></label><label>Employment type<select v-model="submission.employment_type">
                <option value="full_time">Full time</option>
                <option value="part_time">Part time</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
              </select></label><label>Experience level<input v-model="submission.seniority" maxlength="100"
                placeholder="Early career"><small v-if="submission.errors.seniority">{{ submission.errors.seniority
                }}</small></label><label>Salary range <span class="optional-field">Optional</span><input
                v-model="submission.salary_range" maxlength="100" placeholder="₹8–12 LPA"><small
                v-if="submission.errors.salary_range">{{ submission.errors.salary_range
                }}</small></label><label>Application deadline <span class="optional-field">Optional</span><input
                v-model="submission.expires_at" type="date"><small v-if="submission.errors.expires_at">{{
                  submission.errors.expires_at }}</small></label><label class="employer-field-wide">Short summary<textarea
                v-model="submission.summary" required maxlength="500" rows="2"
                placeholder="A clear one or two sentence introduction to the role."></textarea><small
                v-if="submission.errors.summary">{{ submission.errors.summary }}</small></label><label
              class="employer-field-wide">Role description<textarea v-model="submission.description" required
                minlength="30" maxlength="12000" rows="6"
                placeholder="Responsibilities, expectations, benefits, and how the team works."></textarea><small
                v-if="submission.errors.description">{{ submission.errors.description }}</small></label><label
              class="employer-field-wide">Skills <span class="optional-field">Optional · comma separated</span><input
                v-model="submission.skills" maxlength="500" placeholder="Figma, product thinking, user research"><small
                v-if="submission.errors.skills">{{ submission.errors.skills }}</small></label><label
              class="employer-honeypot" aria-hidden="true">Fax number<input v-model="submission.fax_number"
                tabindex="-1" autocomplete="off"></label></div>
          <div class="employer-submit-footer">
            <p>Submitting a listing is free. Our team will review it before publication.</p><button
              class="button button-dark" :disabled="submission.processing">{{ submission.processing ? 'Sending for review…' : 'Submit for review' }}
              <UiIcon name="arrow-up-right" :size="14" />
            </button>
          </div>
        </form>
        <div class="career-filters"><input v-model="q" type="search" placeholder="Role, company, or skill"
            aria-label="Search jobs"><select v-model="employment" aria-label="Filter by employment type">
            <option value="">Any employment</option>
            <option value="full_time">Full time</option>
            <option value="part_time">Part time</option>
            <option value="contract">Contract</option>
            <option value="internship">Internship</option>
          </select></div>
        <div class="career-list">
          <Link v-for="job in jobs.data" :key="job.id" :href="wayfinderJob3.url({ slug: job.slug })" class="career-row">
            <span class="company-monogram">{{ job.company.slice(0, 1) }}</span><span class="career-row-main"><small>{{
                job.company }} · {{ job.location }}</small><b>{{ job.title }}</b><span>{{ job.summary }}</span><span
                class="skill-pills"><i v-for="skill in (job.skills || []).slice(0, 4)" :key="skill">{{ skill
                  }}</i></span></span><span class="career-row-side"><small>{{ job.workplace_type.replace('_', ' ') }} ·
                {{ job.employment_type.replace('_', ' ') }}</small><b v-if="job.salary_range">{{ job.salary_range
                }}</b><span v-if="job.has_applied" class="applied-label">Applied</span>
              <UiIcon v-else name="arrow-up-right" :size="16" />
            </span></Link>
          <div v-if="!jobs.data.length" class="discovery-empty">No open roles match. Check back as the community grows.
          </div>
        </div>
        <div class="discovery-pagination"><span>Page {{ jobs.current_page }} of {{ jobs.last_page }}</span>
          <div>
            <Link v-if="jobs.prev_page_url" :href="jobsRoute.url({ mergeQuery: { page: jobs.current_page - 1 } })">← Newer
            </Link>
            <Link v-if="jobs.next_page_url" :href="jobsRoute.url({ mergeQuery: { page: jobs.current_page + 1 } })">Older →
            </Link>
          </div>
        </div>
        <p class="career-disclaimer">Listings are shared by the Alfrik community. Always review employer details before
          applying.</p>
      </section>
    </main>
  </PublicLayout>
</template>

<style scoped>
  .career-page {
    min-height: 80vh;
    padding: 0 0 88px;
    background: var(--academy-white, var(--academy-white));
    color: var(--academy-ink, var(--academy-ink))
  }

  .career-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.3fr) minmax(290px, .7fr);
    align-items: center;
    gap: clamp(36px, 7vw, 100px);
    padding-top: clamp(52px, 7vw, 88px);
    padding-bottom: clamp(48px, 6vw, 76px)
  }

  .career-hero-copy .eyebrow,
  .career-board .eyebrow {
    color: var(--academy-muted)
  }

  .career-hero h1 {
    font: 450 clamp(3.2rem, 6.2vw, 5.35rem)/.99 var(--serif);
    letter-spacing: -.05em;
    margin: 20px 0 18px;
    color: var(--academy-ink)
  }

  .career-hero h1 em {
    font-family: var(--serif);
    font-weight: 400;
    color: var(--academy-secondary)
  }

  .career-hero-copy>p {
    max-width: 610px;
    margin: 0;
    color: var(--academy-muted);
    font-size: 1.04rem;
    line-height: 1.75
  }

  .career-live-dot {
    display: none
  }

  .career-hero-actions {
    display: flex;
    align-items: center;
    gap: 26px;
    margin-top: 28px
  }

  .career-hero-actions .button {
    min-height: 48px
  }

  .career-hero-actions .text-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .9rem
  }

  .career-employer-card {
    position: relative;
    overflow: hidden;
    padding: 28px 28px 22px;
    background: var(--academy-primary-soft);
    border: 1px solid #d8e0d4;
    border-radius: 0
  }

  .career-employer-card:after {
    position: absolute;
    content: "";
    width: 180px;
    height: 180px;
    right: -92px;
    top: -105px;
    border: 1px solid #cbd6c6;
    border-radius: 50%;
    box-shadow: 0 0 0 22px #ffffff12, 0 0 0 44px #ffffff12;
    pointer-events: none
  }

  .career-employer-icon {
    display: grid;
    place-items: center;
    width: 40px;
    height: 40px;
    margin-bottom: 20px;
    background: var(--academy-paper);
    color: var(--academy-secondary)
  }

  .career-employer-card h2 {
    position: relative;
    z-index: 1;
    margin: 8px 0 10px;
    color: var(--academy-ink);
    font: 450 1.85rem/1.14 var(--serif);
    letter-spacing: -.025em
  }

  .career-employer-card>p {
    position: relative;
    z-index: 1;
    max-width: 370px;
    margin: 0;
    color: var(--academy-muted);
    font-size: .92rem;
    line-height: 1.65
  }

  .career-employer-link {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin: 20px 0;
    padding: 0;
    border: 0;
    background: none;
    color: var(--academy-ink);
    font: 600 .92rem var(--sans);
    cursor: pointer
  }

  .career-employer-link:hover {
    text-decoration: underline;
    text-underline-offset: 4px
  }

  .career-employer-foot {
    display: flex;
    align-items: center;
    gap: 7px;
    border-top: 1px solid #d1dbcd;
    padding-top: 15px;
    color: var(--academy-secondary);
    font-size: .78rem
  }

  .career-board {
    max-width: 1120px;
    scroll-margin-top: 24px;
    padding: 32px 36px;
    background: var(--academy-surface);
    border: 1px solid #e5e3dc;
    border-radius: 0;
    box-shadow: 0 16px 44px #27302608
  }

  .career-board-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    border-bottom: 1px solid #e9e7e0;
    padding-bottom: 21px
  }

  .career-board-head h2 {
    margin: 8px 0 0;
    color: var(--academy-ink);
    font: 450 clamp(1.8rem, 3vw, 2.25rem)/1.14 var(--serif);
    letter-spacing: -.025em
  }

  .career-board-actions {
    display: flex;
    align-items: center;
    gap: 16px
  }

  .career-board-actions>span {
    color: var(--academy-muted);
    font-size: .83rem;
    font-weight: 600
  }

  .career-board-actions .button {
    min-height: 42px;
    white-space: nowrap;
    cursor: pointer
  }

  .career-filters {
    display: flex;
    gap: 10px;
    margin: 21px 0 5px
  }

  .career-filters input,
  .career-filters select {
    min-height: 46px;
    padding: 11px 13px;
    border: 1px solid #deded5;
    border-radius: 0;
    background: var(--academy-paper);
    color: var(--academy-ink);
    font: 400 .94rem var(--sans)
  }

  .career-filters input {
    flex: 1;
    min-width: 0
  }

  .career-filters input:focus,
  .career-filters select:focus {
    outline: 2px solid var(--academy-secondary-light);
    outline-offset: 1px;
    border-color: var(--academy-focus)
  }

  .career-row {
    display: flex;
    align-items: center;
    gap: 17px;
    margin: 0;
    padding: 19px 3px;
    border: 0;
    border-top: 1px solid #eeede7;
    border-radius: 0;
    color: var(--academy-ink);
    transition: background .16s ease
  }

  .career-row:hover {
    background: var(--academy-paper)
  }

  .company-monogram {
    display: grid;
    place-items: center;
    flex: none;
    width: 48px;
    height: 48px;
    border: 1px solid #e1e6dc;
    background: var(--academy-paper);
    color: var(--academy-secondary);
    font-size: 1.12rem;
    font-weight: 600
  }

  .career-row-main {
    display: grid;
    flex: 1;
    min-width: 0;
    gap: 5px
  }

  .career-row-main>small,
  .career-row-side small {
    color: var(--academy-muted);
    font-size: .78rem;
    text-transform: none
  }

  .career-row-main>b {
    color: var(--academy-ink);
    font: 500 1.27rem/1.25 var(--serif);
    letter-spacing: -.01em
  }

  .career-row-main>span:not(.skill-pills) {
    max-width: 720px;
    color: var(--academy-muted);
    font-size: .89rem;
    line-height: 1.55
  }

  .skill-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 3px
  }

  .skill-pills i {
    padding: 4px 8px;
    background: var(--academy-paper);
    color: var(--academy-secondary);
    font-size: .73rem;
    font-style: normal
  }

  .career-row-side {
    display: flex;
    min-width: 150px;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    text-align: right
  }

  .career-row-side small {
    text-transform: capitalize
  }

  .career-row-side b {
    color: var(--academy-secondary);
    font-size: .86rem;
    font-weight: 600
  }

  .career-row-side>svg {
    width: 32px;
    height: 32px;
    padding: 8px;
    border: 1px solid #e1e6dc;
    color: var(--academy-secondary)
  }

  .applied-label {
    color: var(--academy-secondary);
    font-size: .8rem
  }

  .discovery-empty {
    padding: 48px 16px;
    color: var(--academy-muted);
    text-align: center
  }

  .discovery-pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 12px;
    padding: 20px 0;
    border-top: 1px solid #eeede7;
    color: var(--academy-muted);
    font-size: .84rem
  }

  .discovery-pagination div {
    display: flex;
    gap: 18px
  }

  .discovery-pagination a,
  .text-link {
    color: var(--academy-primary)
  }

  .discovery-pagination a:hover,
  .text-link:hover {
    text-decoration: underline;
    text-underline-offset: 4px
  }

  .career-disclaimer {
    margin: 18px 0 0;
    color: var(--academy-muted);
    font-size: .8rem;
    line-height: 1.55
  }

  .employer-submit-form {
    scroll-margin-top: 22px;
    margin: 22px 0 28px;
    padding: 28px;
    background: var(--academy-paper);
    border: 1px solid #e5e8df;
    border-radius: 0
  }

  .employer-submit-heading,
  .employer-submit-footer {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 24px
  }

  .employer-submit-heading h2 {
    margin: 7px 0;
    font: 400 2rem/1.15 var(--serif)
  }

  .employer-submit-heading p,
  .employer-submit-footer p {
    max-width: 600px;
    margin: 0;
    color: var(--academy-muted);
    font-size: .92rem;
    line-height: 1.55
  }

  .employer-submit-note {
    display: flex;
    align-items: center;
    gap: 7px;
    color: var(--academy-secondary);
    font-size: .83rem;
    white-space: nowrap
  }

  .employer-fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px 18px;
    margin-top: 22px
  }

  .employer-fields label {
    display: grid;
    align-content: start;
    gap: 6px;
    color: var(--academy-ink);
    font-size: .85rem;
    font-weight: 600
  }

  .employer-fields input,
  .employer-fields select,
  .employer-fields textarea {
    width: 100%;
    min-width: 0;
    min-height: 44px;
    padding: 11px 12px;
    border: 1px solid #dedfd7;
    border-radius: 0;
    background: var(--academy-surface);
    color: var(--academy-ink);
    font: 400 .94rem/1.45 var(--sans)
  }

  .employer-fields textarea {
    resize: vertical
  }

  .employer-fields :is(input, select, textarea):focus {
    outline: 2px solid var(--academy-secondary-light);
    outline-offset: 1px;
    border-color: var(--academy-focus)
  }

  .employer-fields label>small {
    color: var(--academy-danger);
    font-size: .8rem
  }

  .employer-fields .optional-field {
    color: var(--academy-muted);
    font-size: .76rem;
    font-weight: 400
  }

  .employer-field-wide {
    grid-column: 1/-1
  }

  .employer-honeypot {
    position: absolute !important;
    left: -10000px !important;
    width: 1px !important;
    height: 1px !important;
    overflow: hidden !important
  }

  .employer-submit-footer {
    align-items: center;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #e6e7de
  }

  .employer-submit-footer .button {
    min-height: 46px;
    cursor: pointer
  }

  .employer-submit-footer .button:disabled {
    opacity: .6;
    cursor: wait
  }

  @media(max-width:860px) {
    .career-hero {
      grid-template-columns: minmax(0, 1fr) minmax(270px, .8fr);
      gap: 32px
    }

    .career-board {
      padding: 26px
    }

    .career-row-side {
      min-width: 120px
    }
  }

  @media(max-width:700px) {
    .career-hero {
      grid-template-columns: 1fr;
      gap: 32px;
      padding-top: 52px;
      padding-bottom: 45px
    }

    .career-hero h1 {
      font-size: clamp(3rem, 11vw, 4.2rem)
    }

    .career-board {
      padding: 22px 18px
    }

    .career-board-head {
      align-items: flex-start;
      flex-direction: column;
      gap: 14px
    }

    .career-board-actions {
      width: 100%;
      justify-content: space-between
    }

    .career-row {
      gap: 12px;
      padding: 16px 2px
    }

    .employer-submit-heading,
    .employer-submit-footer {
      align-items: flex-start;
      flex-direction: column
    }

    .employer-submit-note {
      white-space: normal
    }
  }

  @media(max-width:520px) {
    .career-hero-actions {
      align-items: flex-start;
      flex-direction: column;
      gap: 16px
    }

    .career-filters {
      flex-direction: column
    }

    .career-row {
      display: grid;
      grid-template-columns: 42px minmax(0, 1fr);
      align-items: start
    }

    .company-monogram {
      width: 42px;
      height: 42px
    }

    .career-row-main {
      grid-column: 2;
      grid-row: 1
    }

    .career-row-side {
      grid-column: 2;
      grid-row: 2;
      min-width: 0;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
      text-align: left
    }

    .career-row-side>svg {
      margin-left: auto
    }

    .career-row-main>span:not(.skill-pills) {
      font-size: .85rem
    }

    .employer-submit-form {
      padding: 19px
    }

    .employer-fields {
      grid-template-columns: 1fr
    }

    .employer-field-wide {
      grid-column: auto
    }

    .discovery-pagination {
      gap: 12px
    }

    .discovery-pagination div {
      gap: 10px
    }
  }
</style>