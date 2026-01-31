<template>
  <div class="project">
    <h1 class="my-4">project edit page</h1>
  </div>

  <form @submit.prevent="submitForm">
    <div class="mb-3">
      <label for="projectTitle" class="form-label">Title</label>
      <input id="projectTitle" v-model="data.title" class="form-control">
    </div>
    <div class="mb-3">
      <label for="projectDescription" class="form-label">Description</label>
      <textarea id="projectDescription" v-model="data.description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label>Translators</label>
      <Multiselect
          v-model="data.translators"
          :options="translators"
          :multiple="true"
          :close-on-select="false"
          label="name"
          track-by="id"
          placeholder="Select Translators"
      />
    </div>

    <button type="submit" :disabled="isSubmitting" class="btn btn-primary">
      {{ isSubmitting ? 'Submitting...' : 'Submit' }}
    </button>
  </form>
</template>

<script lang="ts">
import {defineComponent, ref, onMounted, inject} from 'vue'
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import {Api} from "@/api";

export default defineComponent({
  name: 'ProjectUpdatePage',
  components: {
    Multiselect
  },
  setup () {
    const api = inject<Api>('api')
    if (!api) {
      throw new Error('API not provided')
    }
    const translators = ref([])
    const data = ref({
      title: '',
      description: '',
      translators: []
    });

    const isSubmitting = ref(false);
    const message = ref('');
    const error = ref('');

    onMounted(async () => {
      const availabilityList = await api.translatorAvailabilityList()
      data.value = await api.view('/project/project', "&expand=translators")
      translators.value = await api.request('GET', '/project/translator/list?project_id='+data.value.id)
      // add "availability" name postfix
      for (let i in translators.value) {
          translators.value[i].name = translators.value[i].name
            + ' (' + availabilityList[translators.value[i].availability]+')'
      }
    })

    const submitForm = async () => {
      isSubmitting.value = true;
      message.value = '';
      error.value = '';

      try {
        await api.update('/project/project', '', data)
      } catch (err) {
        error.value = 'An error occurred during submission.';
        console.error('Error:', err);
      } finally {
        isSubmitting.value = false;
      }
    };
    return {
      data, translators, submitForm, isSubmitting
    }
  }
})
</script>