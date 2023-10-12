import {createRouter, createWebHistory} from "vue-router";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', component: () => import('../js/components/Home.vue'), name: 'home'},
        {path: '/desks', component: () => import('../js/components/Desk.vue'), name: 'desk'},
        {path: '/desks/create', component: () => import('../js/components/CreateDesk.vue'), name: 'create.desk'},
        {
            path: '/desks/:id', component: () => import('../js/components/ShowDesk.vue'),
            name: 'show.desk', props: true
        },
    ],
});

export default router;
