import { createWebHistory, createRouter } from "vue-router";
import MainPage from "../views/pages/MainPage";
import AdminPage from "../views/pages/AdminPage";
import LoginPage from "../views/pages/LoginPage";
import NotFound from "../views/pages/NotFound";

const routes = [
    {
        path: "/",
        name: MainPage,
        component: MainPage,
        meta: {
            layout: "main",
            auth: true,
            admin: false,
        },
    },
    {
        path: "/admin",
        name: AdminPage,
        component: AdminPage,
        meta: {
            layout: "main",
            auth: true,
            admin: true,
        },
    },
    {
        path: "/login",
        name: LoginPage,
        component: LoginPage,
        meta: {
            layout: "auth",
            auth: false,
            admin: false,
        },
    },
    {
        path: "/:notFound(.*)",
        name: NotFound,
        component: NotFound,
        meta: {
            layout: "main",
            auth: true,
            admin: false,
        },
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(process.env.BASE_URL),
    linkActiveClass: "active",
    linkExactActiveClass: "active",
});

router.beforeEach((to, from, next) => {
    const requireAuth = to.meta.auth;
    const login = localStorage.getItem("login");

    if (requireAuth && login) {
        next();
    } else if (requireAuth && !login) {
        next("/login?message=auth");
    } else if (!requireAuth && login) {
        next("/");
    } else {
        next();
    }
});

export default router;
