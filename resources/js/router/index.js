import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from "./../views/Home"
import UserList from "./../views/utilisateurs/List";
import UserAdd from "./../views/utilisateurs/AddAndEdit";

const router =new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/utilisateurs',
            name: 'utilisateurs',
            component: UserList
        },
        {
            path: '/utilisateurs/new',
            name: 'utilisateurs.add',
            component: UserList
        },
        {
            path: '/utilisateurs/edit/:id',
            name: 'utilisateurs.edit',
            component: UserAdd
        },
    ]
});

export default router;
