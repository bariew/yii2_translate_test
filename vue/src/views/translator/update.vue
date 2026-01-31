<template>
  <div class="project">
    <h1 class="my-4">translator {{data.name}} edit page</h1>
  </div>

  <form @submit.prevent="submitForm">
    <div class="mb-3">
      <label for="translatorName" class="form-label">Name</label>
      <input id="translatorName" v-model="data.name" class="form-control">
    </div>
    <div class="mb-3">
      <label for="translatorAvailability" class="form-label">Availability</label>
      <select id="translatorAvailability" v-model="data.availability" class="form-control">
        <option></option>
        <option
            v-for="(item, index) in availabilityList"
            :key="index"
            :value="index"
        >
          {{ item }}
        </option>
      </select>
    </div>

    <div class="mb-3">
      <label>Projects</label>
      <Multiselect
          v-model="data.projects"
          :options="projects"
          :multiple="true"
          :close-on-select="false"
          label="name"
          track-by="id"
          placeholder="Select Projects"
      />
    </div>

    <button type="submit" :disabled="isSubmitting" class="btn btn-primary">
      {{ isSubmitting ? 'Submitting...' : 'Submit' }}
    </button>
  </form>
</template>

<script lang="ts">
import {defineComponent, ref, onMounted, inject} from 'vue'
import type { Api } from '@/api'
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

export default defineComponent({
  name: 'TranslatorUpdatePage',
  components: {
    Multiselect
  },
  setup () {
    const api = inject<Api>('api')
    if (!api) {
      throw new Error('API not provided')
    }
    const data = ref({
      name: "",
      availability: 0,
      projects: []
    });
    const projects = ref([])
    const availabilityList = ref({})
    const isSubmitting = ref(false);
    const message = ref('');
    const error = ref('');

    onMounted(async () => {
      data.value = await api.view('/project/translator', "&expand=projects")
      data.value.projects = data.value.projects ? data.value.projects.map(w => ({id: w.id, name: w.title})) : []

      projects.value = await api.index('/project/project', '')
      projects.value = projects.value.map(v => ({id: v.id, "name": v.title}))
      availabilityList.value = await api.translatorAvailabilityList()

    })

    const submitForm = async () => {
      isSubmitting.value = true;
      message.value = '';
      error.value = '';

      try {
         await api.update('/project/translator', '', data)
      } catch (err) {
        error.value = 'An error occurred during submission.';
        console.error('Error:', err);
      } finally {
        isSubmitting.value = false;
      }
    };
    return {
      data, projects, availabilityList, submitForm, isSubmitting
    }
  }
})
</script>