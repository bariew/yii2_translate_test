<template>
  <div class="project">
    <h1 class="my-4">Projects page</h1>
  </div>

  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Working Days</th>
      <th>Holidays</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="project in gridData" :key="project.id">
      <td>{{ project.id }}</td>
      <td>{{ project.title }}</td>
      <td>{{ project.translators.filter(v => v.availability==1).map(v => v.name).join(', ') }}</td>
      <td>{{ project.translators.filter(v => v.availability==2).map(v => v.name).join(', ') }}</td>
      <td><router-link :to="{ name: 'ProjectUpdate', params: { id: project.id } }"><i class="btn btn-sm fa fa-edit"></i></router-link></td>
    </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, inject } from 'vue'
import {Api} from "@/api";

export default defineComponent({
  name: 'ProjectsPage',
  setup () {
    const api = inject<Api>('api')
    if (!api) {
      throw new Error('API not provided')
    }
    const gridData = ref([])
    onMounted(async () => {
      gridData.value = await api.index('/project/project', '?expand=translators')
    })

    return {
      gridData
    }
  }
})
</script>