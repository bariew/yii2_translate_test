<template>
  <div class="home">
    <img alt="Vue logo" src="./images/logo.png" />
    <HelloWorld msg="Translators" />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import HelloWorld from './components/hello-world.vue'

export default defineComponent({
  name: 'HomePage',
  components: { HelloWorld },
})
</script>
