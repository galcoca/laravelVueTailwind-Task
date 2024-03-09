import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './components/App.vue'

import HomeView from './components/views/HomeView.vue'
import LoginView from './components/views/LoginView.vue'
import RegisterView from './components/views/RegisterView.vue'
import DashboardView from './components/views/DashboardView.vue'
import ValidationView from './components/views/ValidationView.vue'

let routes = [
    { path: "/home", component: HomeView },
    { path: "/", component: HomeView },
    { path: "/register", component: RegisterView },
    { path: "/dashboard", component: DashboardView, props:true },
    { path: "/validatePhone", component: ValidationView, props:true },
    { path: "/login", component: LoginView }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);

app.config.devtools = false;
app.use(router);
app.mount('#app')