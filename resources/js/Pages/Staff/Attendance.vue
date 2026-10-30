<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import StaffAdminLayout from '../../Layouts/StaffAdminLayout.vue';
import { sessions as sessionsRoute, updateAttendance } from '../../actions/App/Http/Controllers/Staff/AdminOperationsController';

const props = defineProps({ session: { type: Object, required: true }, learners: { type: Array, required: true } });
const form = useForm({ attendance: props.learners.map((learner) => ({ user_id: learner.id, status: learner.status, minutes_attended: learner.minutesAttended })) });
const statuses = [
  { value: 'unmarked', label: 'Not marked' },
  { value: 'present', label: 'Present' },
  { value: 'late', label: 'Late' },
  { value: 'absent', label: 'Absent' },
  { value: 'excused', label: 'Excused' },
];
function markAll(status) { form.attendance.forEach((entry) => { entry.status = status; }); }
function save() { form.put(updateAttendance.url({ liveSession: props.session.id }), { preserveScroll: true }); }
function localTime(value) { return new Intl.DateTimeFormat(undefined, { dateStyle: 'medium', timeStyle: 'short', timeZone: props.session.timezone }).format(new Date(value)); }
</script>

<template>
  <StaffAdminLayout>
    <div class="admin-heading attendance-heading">
      <div><Link class="attendance-back" :href="sessionsRoute().url"><UiIcon name="arrow-left" :size="13" /> Cohorts & live classes</Link><div class="eyebrow">CLASS RECORD</div><h1>Attendance.</h1><p>{{ session.course }} · {{ session.cohort }} · {{ localTime(session.startsAt) }}</p></div>
      <button class="button button-dark" :disabled="form.processing" @click="save">{{ form.processing ? 'Saving…' : 'Save attendance' }} <UiIcon name="check" :size="14" /></button>
    </div>
    <section class="admin-panel attendance-panel">
      <div class="attendance-toolbar"><div><h2>{{ session.title }}</h2><p>{{ learners.length }} active {{ learners.length === 1 ? 'learner' : 'learners' }} in this cohort</p></div><div><button type="button" @click="markAll('present')">Mark all present</button><button type="button" @click="markAll('unmarked')">Clear marks</button></div></div>
      <form @submit.prevent="save">
        <div v-if="learners.length" class="attendance-table-wrap"><table class="attendance-table"><thead><tr><th>Learner</th><th>Attendance</th><th>Minutes attended</th></tr></thead><tbody><tr v-for="(learner, index) in learners" :key="learner.id"><td><b>{{ learner.name }}</b><small>{{ learner.email }}</small></td><td><select v-model="form.attendance[index].status"><option v-for="status in statuses" :key="status.value" :value="status.value">{{ status.label }}</option></select></td><td><input v-model.number="form.attendance[index].minutes_attended" type="number" min="0" max="720" step="1" :disabled="!['present', 'late'].includes(form.attendance[index].status)" aria-label="Minutes attended"></td></tr></tbody></table></div>
        <div v-else class="admin-empty">There are no active learners in this cohort yet.</div>
        <p v-if="form.errors.attendance" class="attendance-error" role="alert">{{ form.errors.attendance }}</p>
        <div class="attendance-footer"><small>Attendance changes are recorded in the staff audit history.</small><button class="button button-dark" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save attendance' }} <UiIcon name="check" :size="14" /></button></div>
      </form>
    </section>
  </StaffAdminLayout>
</template>

<style scoped>
.attendance-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:20px}.attendance-back{display:inline-flex;align-items:center;gap:6px;margin-bottom:19px;color:var(--academy-secondary);font-size:10px;font-weight:650}.attendance-heading h1{margin:8px 0;font:500 clamp(2.2rem,5vw,3rem)/1.04 var(--serif);letter-spacing:-.04em}.attendance-heading p{margin:0;color:var(--academy-muted);font-size:12px}.attendance-panel{padding:22px}.attendance-toolbar{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:14px}.attendance-toolbar h2{margin:0 0 4px;font:500 21px var(--serif)}.attendance-toolbar p{margin:0;font-size:10px;color:var(--academy-muted)}.attendance-toolbar>div:last-child{display:flex;gap:7px}.attendance-toolbar button{border:1px solid #e5e4dc;border-radius:4px;background:white;padding:8px 10px;font-size:9px;color:var(--academy-primary);cursor:pointer}.attendance-table-wrap{overflow-x:auto}.attendance-table{width:100%;border-collapse:collapse;text-align:left}.attendance-table th{padding:10px;border-bottom:1px solid #e8e7df;color:var(--academy-muted);font-size:8px;letter-spacing:.08em;text-transform:uppercase}.attendance-table td{padding:12px 10px;border-bottom:1px solid #efeee8}.attendance-table td:first-child{min-width:180px}.attendance-table td>b,.attendance-table td>small{display:block}.attendance-table td>b{font-size:11px}.attendance-table td>small{margin-top:4px;color:var(--academy-muted);font-size:9px}.attendance-table select,.attendance-table input{width:100%;max-width:190px;min-height:37px;border:1px solid #e4e3dc;border-radius:4px;background:var(--academy-surface);padding:0 9px;font-size:10px}.attendance-table input{max-width:120px}.attendance-table input:disabled{background:var(--academy-paper);color:var(--academy-muted)}.attendance-footer{display:flex;align-items:center;justify-content:space-between;gap:15px;padding-top:18px}.attendance-footer small{color:var(--academy-muted);font-size:9px}.attendance-error{color:var(--academy-danger);font-size:10px}.theme-dark .attendance-table td{border-color:var(--academy-border)}.theme-dark .attendance-table th{border-color:var(--academy-border);color:var(--academy-muted)}.theme-dark .attendance-toolbar button,.theme-dark .attendance-table select,.theme-dark .attendance-table input{background:var(--academy-surface);color:var(--academy-contrast);border-color:var(--academy-ink)}.theme-dark .attendance-table td>b{color:var(--academy-contrast)}.theme-dark .attendance-table td>small,.theme-dark .attendance-toolbar p{color:var(--academy-muted)}
@media(max-width:640px){.attendance-heading{align-items:flex-start;flex-direction:column}.attendance-heading>.button{min-height:42px}.attendance-panel{padding:14px}.attendance-toolbar{align-items:flex-start;flex-direction:column}.attendance-table th,.attendance-table td{padding:10px 7px}.attendance-table td:first-child{min-width:145px}.attendance-footer{align-items:flex-start;flex-direction:column}.attendance-footer .button{min-height:42px}}
</style>
