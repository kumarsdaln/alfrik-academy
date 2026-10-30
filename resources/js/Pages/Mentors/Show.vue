<script setup>
import { course as wayfinderCourse, mentors as wayfinderMentors } from './../../actions/App/Http/Controllers/PublicController';
import { Link } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import ShareButton from '../../Components/ShareButton.vue';

defineProps({ mentor: Object, courses: Array });
</script>

<template>
  <PublicLayout>
    <main class="mentor-page">
      <div class="wrap mentor-page-wrap">
        <nav class="mentor-breadcrumb" aria-label="Breadcrumb">
          <Link :href="wayfinderMentors().url">Mentors</Link>
          <span aria-hidden="true">/</span>
          <span aria-current="page">{{ mentor.name }}</span>
        </nav>

        <section class="mentor-profile-hero">
          <figure class="mentor-portrait">
            <img :src="`/images/learning/${mentor.slug}.png`" :alt="mentor.name" fetchpriority="high">
            <figcaption>{{ mentor.field }}</figcaption>
          </figure>
          <div class="mentor-introduction">
            <div class="eyebrow">A ALFRIK MENTOR · {{ mentor.field }}</div>
            <h1>{{ mentor.name }}</h1>
            <p class="mentor-role">{{ mentor.role }}</p>
            <p class="mentor-intro-copy">{{ mentor.intro }}</p>
            <div class="mentor-stats">
              <div><strong>{{ mentor.years }}<span>+</span></strong><small>years in the field</small></div>
              <div><strong>{{ mentor.learners }}</strong><small>learners supported</small></div>
            </div>
            <ShareButton :title="mentor.name + ' · ' + mentor.role" :text="mentor.intro" />
          </div>
        </section>

        <div class="mentor-profile-content">
          <article class="mentor-story">
            <section class="mentor-bio-section">
              <div class="eyebrow">GET TO KNOW {{ mentor.name.split(' ')[0].toUpperCase() }}</div>
              <h2>Experience, shared generously.</h2>
              <p>{{ mentor.bio }}</p>
            </section>
            <blockquote v-if="mentor.quote" class="mentor-quote">
              <span class="eyebrow">A NOTE FOR LEARNERS</span>
              <p>“{{ mentor.quote }}”</p>
            </blockquote>
            <section v-if="mentor.specialties?.length" class="mentor-specialties">
              <div class="eyebrow">AREAS OF PRACTICE</div>
              <h2>Things we can explore together.</h2>
              <ul><li v-for="specialty in mentor.specialties" :key="specialty">{{ specialty }}</li></ul>
            </section>
          </article>

          <aside class="mentor-learning">
            <div class="eyebrow">LEARN WITH {{ mentor.name.split(' ')[0].toUpperCase() }}</div>
            <h2>Live learning, with a practitioner.</h2>
            <p class="mentor-learning-intro">Build your skills alongside someone who works in the field every day.</p>
            <div v-if="courses.length" class="mentor-courses">
              <Link v-for="course in courses" :key="course.slug" :href="wayfinderCourse.url({ slug: course.slug })" class="mentor-course">
                <span class="mentor-course-meta">{{ course.weeks }} weeks <span aria-hidden="true">·</span> {{ course.live_classes }} live classes</span>
                <strong>{{ course.title }}</strong>
                <span class="mentor-course-link">Explore the course <UiIcon name="arrow-up-right" :size="14" /></span>
              </Link>
            </div>
            <p v-else class="mentor-no-courses">New learning programs with {{ mentor.name.split(' ')[0] }} are on the way. Explore the full course catalog to find your next step.</p>
          </aside>
        </div>
      </div>
    </main>
  </PublicLayout>
</template>

<style scoped>
.mentor-page{min-height:80vh;padding:0 0 88px;background:var(--academy-paper,var(--academy-paper));color:var(--academy-ink,var(--academy-ink))}
.mentor-page-wrap{max-width:1160px}
.mentor-breadcrumb{display:flex;align-items:center;gap:10px;min-width:0;padding:25px 0;color:var(--academy-muted);font-size:.8rem}
.mentor-breadcrumb a{flex:none;color:var(--academy-secondary);text-decoration:none}
.mentor-breadcrumb a:hover{text-decoration:underline;text-underline-offset:4px}
.mentor-breadcrumb>span[aria-current="page"]{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.mentor-profile-hero{display:grid;grid-template-columns:minmax(280px,.78fr) minmax(0,1.22fr);align-items:center;gap:clamp(36px,7vw,92px);padding:26px 0 54px;border-top:1px solid #e5e3dc;border-bottom:1px solid #e5e3dc}
.mentor-portrait{position:relative;min-width:0;height:clamp(360px,42vw,500px);margin:0;background:var(--academy-paper);overflow:hidden}
.mentor-portrait img{display:block;width:100%;height:100%;object-fit:cover;object-position:center 28%}
.mentor-portrait figcaption{position:absolute;left:16px;bottom:16px;max-width:calc(100% - 32px);padding:9px 11px;background:var(--academy-paper);color:var(--academy-secondary);font-size:.7rem;font-weight:600;letter-spacing:.07em;text-transform:uppercase}
.mentor-introduction{min-width:0}
.mentor-introduction>.eyebrow{color:var(--academy-secondary-light)}
.mentor-introduction h1{margin:17px 0 9px;color:var(--academy-ink);font:450 clamp(3rem,6.2vw,5.5rem)/.98 var(--serif);letter-spacing:-.055em}
.mentor-role{margin:0;color:var(--academy-secondary);font:450 clamp(1.2rem,2.4vw,1.7rem)/1.35 var(--serif)}
.mentor-intro-copy{max-width:650px;margin:16px 0 0;color:var(--academy-muted);font-size:1rem;line-height:1.75}
.mentor-stats{display:flex;gap:0;margin:26px 0 20px;border-top:1px solid #e5e3dc;border-bottom:1px solid #e5e3dc}
.mentor-stats>div{display:grid;gap:4px;padding:15px 26px 15px 0}
.mentor-stats>div+div{padding-left:25px;border-left:1px solid #e5e3dc}
.mentor-stats strong{color:var(--academy-ink);font:450 1.55rem/1.1 var(--serif)}
.mentor-stats strong span{color:var(--academy-secondary)}
.mentor-stats small{color:var(--academy-muted);font-size:.75rem}
.mentor-introduction :deep(.share-button){min-height:40px;padding:8px 0;border:0;background:transparent;color:var(--academy-primary);font-size:.78rem}
.mentor-introduction :deep(.share-button:hover){background:transparent;text-decoration:underline;text-underline-offset:4px}
.mentor-profile-content{display:grid;grid-template-columns:minmax(0,1fr) 350px;align-items:start;gap:clamp(40px,7vw,94px);padding-top:48px}
.mentor-story{min-width:0}
.mentor-bio-section h2,.mentor-specialties h2,.mentor-learning h2{margin:9px 0 16px;color:var(--academy-ink);font:450 clamp(1.8rem,3.5vw,2.45rem)/1.16 var(--serif);letter-spacing:-.03em}
.mentor-bio-section>p{margin:0;color:var(--academy-muted);font-size:1rem;line-height:1.85;white-space:pre-line}
.mentor-quote{margin:36px 0;padding:23px 0 23px 22px;border-left:2px solid #778b6d;color:var(--academy-ink)}
.mentor-quote p{margin:10px 0 0;font:400 clamp(1.35rem,2.7vw,1.9rem)/1.5 var(--serif);letter-spacing:-.015em}
.mentor-specialties{padding-top:24px;border-top:1px solid #e5e3dc}
.mentor-specialties h2{font-size:1.8rem}
.mentor-specialties ul{display:flex;flex-wrap:wrap;gap:0 22px;margin:20px 0 0;padding:0;list-style:none}
.mentor-specialties li{padding:10px 0;border-bottom:1px solid #e5e3dc;color:var(--academy-secondary);font-size:.88rem}
.mentor-learning{position:sticky;top:24px;padding:24px;background:var(--academy-surface);border:1px solid #e3e3da;border-top:3px solid var(--academy-primary)}
.mentor-learning>.eyebrow{color:var(--academy-secondary-light)}
.mentor-learning h2{margin-bottom:9px;font-size:1.75rem}
.mentor-learning-intro,.mentor-no-courses{margin:0 0 17px;color:var(--academy-muted);font-size:.86rem;line-height:1.65}
.mentor-courses{border-top:1px solid #e7e6df}
.mentor-course{display:grid;gap:9px;padding:17px 0;border-bottom:1px solid #e7e6df;color:inherit;text-decoration:none}
.mentor-course:hover strong{color:var(--academy-secondary)}
.mentor-course-meta{color:var(--academy-muted);font-size:.74rem;text-transform:capitalize}
.mentor-course strong{color:var(--academy-ink);font:500 1.22rem/1.25 var(--serif);transition:color .15s}
.mentor-course-link{display:flex;align-items:center;gap:7px;color:var(--academy-primary);font-size:.78rem;font-weight:600}
.mentor-no-courses{margin:16px 0 0}
@media(max-width:850px){.mentor-profile-hero{grid-template-columns:minmax(230px,.78fr) minmax(0,1.22fr);gap:32px}.mentor-portrait{height:390px}.mentor-profile-content{grid-template-columns:minmax(0,1fr) 300px;gap:32px}.mentor-learning{padding:21px}}
@media(max-width:700px){.mentor-profile-hero{grid-template-columns:1fr;gap:26px;padding:20px 0 34px}.mentor-portrait{height:clamp(300px,88vw,480px)}.mentor-introduction h1{font-size:clamp(3rem,11vw,4.4rem)}.mentor-profile-content{grid-template-columns:1fr;gap:34px;padding-top:34px}.mentor-learning{position:static;grid-row:1}.mentor-story{grid-row:2}}
@media(max-width:520px){.mentor-page-wrap{padding-right:18px;padding-left:18px}.mentor-breadcrumb{padding:19px 0;font-size:.75rem}.mentor-portrait{height:clamp(280px,95vw,410px)}.mentor-stats>div{padding-right:18px}.mentor-stats>div+div{padding-left:18px}.mentor-stats strong{font-size:1.4rem}.mentor-learning{padding:20px}.mentor-bio-section h2,.mentor-specialties h2{font-size:1.8rem}}
</style>