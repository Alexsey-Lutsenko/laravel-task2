import { createWebHistory, createRouter } from "vue-router";
import GalleryPage from "../views/pages/GalleryPage";
import MainPage from "../views/pages/MainPage";
import OrderPhotoPage from "../views/pages/OrderPhotoPage";
import TitlePage from "../views/pages/TitlePage";
import AdminPage from "../views/pages/AdminPage";
import LoginPage from "../views/pages/LoginPage";
import NotFound from "../views/pages/NotFound";
import store from "../store";

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
        path: "/order-photo",
        name: OrderPhotoPage,
        component: OrderPhotoPage,
        meta: {
            layout: "main",
            auth: true,
            admin: false,
        },
    },
    {
        path: "/title",
        name: TitlePage,
        component: TitlePage,
        meta: {
            layout: "main",
            auth: true,
            admin: false,
        },
    },
    {
        path: "/gallery",
        name: GalleryPage,
        component: GalleryPage,
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
    const patch = to.path;
    const title = store.getters["title/getTitle"];

    if (requireAuth && !login) {
        next("/login?message=auth");
    } else if (!requireAuth && login) {
        next("/");
    } else if (requireAuth && login && patch == "/title" && Object.keys(title).length == 0) {
        next("/");
    } else if (requireAuth && login) {
        next();
    } else {
        next();
    }
});

export default router;
