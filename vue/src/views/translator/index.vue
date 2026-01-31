<template>
  <div class="translator">
    <h1 class="my-4">Translator search page</h1>
  </div>

  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Availability</th>
      <th>Projects</th>
      <th></th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th>
        <select v-model="selectedAvailability">
          <option></option>
          <option
              v-for="(item, index) in availabilityList"
              :key="index"
              :value="index"
          >
            {{ item }}
          </option>
        </select>
      </th>
      <th></th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="translator in filteredData" :key="translator.id">
      <td>{{ translator.id }}</td>
      <td>{{ translator.name }}</td>
      <td>{{ availabilityList[translator.availability] }}</td>
      <td>{{ translator.projects.map(v => v.title).join(', ') }}</td>
      <td><router-link :to="{ name: 'TranslatorUpdate', params: { id: translator.id } }"><i class="btn btn-sm fa fa-edit"></i></router-link></td>
    </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed, inject } from 'vue'
import type { Api } from '@/api'

export default defineComponent({
  name: 'TranslatorsPage',
  setup () {
    const api = inject<Api>('api')
    if (!api) {
      throw new Error('API not provided')
    }
    const gridData = ref([])
    const selectedAvailability = ref('')
    const availabilityList = ref({})

    onMounted(async () => {
      gridData.value = await api.index('/project/translator', '?expand=projects')
      availabilityList.value = await api.translatorAvailabilityList()
    })

    const filteredData = computed(() => {
      if (!selectedAvailability.value) {
        return gridData.value
      }
      return gridData.value.filter(item =>
          item.availability == parseInt(selectedAvailability.value)
      )
    })
    return {
      filteredData, availabilityList, selectedAvailability
    }
  }
})
</script>