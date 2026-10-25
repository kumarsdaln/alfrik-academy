<script setup>
import { ref } from 'vue';

const props = defineProps({
  title: { type: String, required: true },
  text: { type: String, default: '' },
  label: { type: String, default: 'Share' },
});

const status = ref('');
let resetTimer;

function announce(message) {
  status.value = message;
  window.clearTimeout(resetTimer);
  resetTimer = window.setTimeout(() => { status.value = ''; }, 2200);
}

async function share() {
  const url = window.location.href;

  try {
    if (navigator.share) {
      await navigator.share({ title: props.title, text: props.text, url });
      return;
    }

    if (!navigator.clipboard?.writeText) {
      announce('Copy this page from the address bar');
      return;
    }

    await navigator.clipboard.writeText(url);
    announce('Link copied');
  } catch (error) {
    if (error.name !== 'AbortError') announce('Unable to share right now');
  }
}
</script>

<template>
  <button class="share-button" type="button" @click="share">
    <UiIcon :name="status === 'Link copied' ? 'check' : 'share'" :size="15" />
    <span>{{ status || label }}</span>
    <span class="share-button-status" role="status" aria-live="polite">{{ status && status !== label ? status : '' }}</span>
  </button>
</template>

<style scoped>
.share-button{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:38px;padding:8px 12px;border:1px solid #dfe2d9;border-radius:4px;background:#fff;color:#465a40;font:inherit;font-size:.74rem;font-weight:600;cursor:pointer;transition:border-color .15s,background .15s,color .15s}.share-button:hover{border-color:#aebaa6;background:#f4f6f1;color:#354532}.share-button:focus-visible{outline:3px solid #82977755;outline-offset:2px}.share-button-status{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}
</style>
