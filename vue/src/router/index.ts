import { RouteRecordRaw, createRouter, createWebHashHistory } from 'vue-router'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'Home',
        component: () => import(/* webpackChunkName: "home" */ '../views/home/index.vue'),
    },
    {
        path: '/projects',
        name: 'Projects',
        component: () => import(/* webpackChunkName: "about" */ '../views/project/index.vue'),
    },
    {
        path: '/project/:id',
        name: 'ProjectUpdate',
        component: () => import(/* webpackChunkName: "about" */ '../views/project/update.vue'),
    },
    {
        path: '/translators',
        name: 'Translators',
        component: () => import(/* webpackChunkName: "about" */ '../views/translator/index.vue'),
    },
    {
        path: '/translator/:id',
        name: 'TranslatorUpdate',
        component: () => import(/* webpackChunkName: "about" */ '../views/translator/update.vue'),
    },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router
