import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import { api } from './api'

createApp(App).provide('api', api).use(router).use(createPinia()).mount('#app')
