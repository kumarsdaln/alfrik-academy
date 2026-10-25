<script setup>
const questions = defineModel({ type: Array, default: () => [] });

function addQuestion() {
  questions.value.push({ id: `q_${Date.now()}_${Math.random().toString(36).slice(2, 7)}`, prompt: '', type: 'single_choice', required: true, options: ['', ''] });
}

function setType(question, type) {
  question.type = type;
  question.options = type === 'text' ? [] : (question.options?.length >= 2 ? question.options : ['', '']);
}
</script>

<template>
  <section class="survey-question-editor" aria-label="Survey questions">
    <div class="survey-question-heading"><div><strong>Survey questions</strong><small>These appear on the public survey page.</small></div><button type="button" class="survey-add-question" @click="addQuestion">+ Add question</button></div>
    <p v-if="!questions.length" class="survey-question-empty">Add at least one question before publishing this survey.</p>
    <article v-for="(question, index) in questions" :key="question.id" class="survey-question-card">
      <div class="survey-question-card-heading"><span>QUESTION {{ index + 1 }}</span><button type="button" aria-label="Remove question" @click="questions.splice(index, 1)">Remove</button></div>
      <label>Question text<input v-model="question.prompt" maxlength="240" required placeholder="What would you like to ask?"></label>
      <div class="survey-question-controls"><label>Answer format<select :value="question.type" @change="setType(question, $event.target.value)"><option value="single_choice">Choose one</option><option value="multiple_choice">Choose all that apply</option><option value="text">Written answer</option></select></label><label class="survey-required-toggle"><input v-model="question.required" type="checkbox"> Required</label></div>
      <div v-if="question.type !== 'text'" class="survey-options"><label v-for="(option, optionIndex) in question.options" :key="optionIndex">Option {{ optionIndex + 1 }}<span><input v-model="question.options[optionIndex]" maxlength="120" required placeholder="Answer option"><button v-if="question.options.length > 2" type="button" :aria-label="`Remove option ${optionIndex + 1}`" @click="question.options.splice(optionIndex, 1)">×</button></span></label><button v-if="question.options.length < 20" type="button" class="survey-add-option" @click="question.options.push('')">+ Add answer option</button></div>
    </article>
  </section>
</template>

<style scoped>
.survey-question-editor{display:grid;gap:12px;padding:17px;border:1px solid #e5e6df;border-radius:6px;background:#fafaf7}.survey-question-heading,.survey-question-card-heading,.survey-question-controls{display:flex;align-items:center;justify-content:space-between;gap:12px}.survey-question-heading>div{display:grid;gap:4px}.survey-question-heading strong{font-size:.86rem;color:#354532}.survey-question-heading small,.survey-question-empty{font-size:.74rem;color:#7d8279}.survey-question-heading button,.survey-question-card-heading button,.survey-add-option{border:0;background:none;color:#465b40;font:inherit;font-size:.74rem;font-weight:600;cursor:pointer}.survey-question-card{display:grid;gap:11px;padding:14px;background:white;border:1px solid #e8e9e2;border-radius:5px}.survey-question-card-heading span{font-size:.62rem;letter-spacing:.12em;color:#8a8f85;font-weight:700}.survey-question-card label,.survey-options>label{display:grid;gap:5px;color:#5c6658;font-size:.72rem}.survey-question-card input:not([type=checkbox]),.survey-question-card select{width:100%;min-height:38px;padding:8px 10px;border:1px solid #dfe2d9;border-radius:4px;background:#fff;color:#30372f;font:inherit;font-size:.78rem}.survey-question-controls{justify-content:flex-start}.survey-question-controls>label{min-width:190px}.survey-question-controls .survey-required-toggle{display:flex;align-items:center;gap:7px;margin-top:16px}.survey-required-toggle input{accent-color:#40543b}.survey-options{display:grid;gap:10px}.survey-options>label span{display:flex;gap:6px}.survey-options button:not(.survey-add-option){width:34px;border:1px solid #e4e5de;border-radius:4px;background:#fff;color:#9c5750;font-size:1.2rem;cursor:pointer}.survey-add-option{justify-self:start;padding:2px 0}@media(max-width:560px){.survey-question-heading,.survey-question-controls{align-items:flex-start;flex-direction:column}.survey-question-controls .survey-required-toggle{margin:0}}
</style>
