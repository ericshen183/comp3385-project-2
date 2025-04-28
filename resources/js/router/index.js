import { createRouter, createWebHistory } from 'vue-router';
import RegisterPage from '../pages/RegisterPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import DashboardPage from '../pages/DashboardPage.vue';
import ExplorePage from '../pages/ExplorePage.vue';
import UserProfilePage from '../pages/UserProfilePage.vue';
import NewCarPage from '../pages/NewCarPage.vue';
import CarDetailsPage from '../pages/CarDetailsPage.vue';

const routes = [
    { path: '/', component: DashboardPage },
    { path: '/register', component: RegisterPage },
    { path: '/login', component: LoginPage },
    { path: '/logout', component: LoginPage }, // Redirect to login for now
    { path: '/explore', component: ExplorePage },
    { path: '/users/:user_id', component: UserProfilePage, props: true },
    { path: '/cars/new', component: NewCarPage },
    { path: '/cars/:car_id', component: CarDetailsPage, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
