import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from "./../views/Home"
import UserList from "./../views/utilisateurs/List";
import UserAdd from "./../views/utilisateurs/AddAndEdit";

import ClasseList from "./../views/classes/List";
import ClasseAdd from "./../views/classes/AddAndEdit";
import ClasseInfo from "./../views/classes/Informations";

import FraisList from "./../views/frais/List";
import FraisAdd from "./../views/frais/AddAndEdit";
import FraisInfo from "./../views/frais/Informations";

import ParentList from "./../views/parents/List";
import ParentAdd from "./../views/parents/AddAndEdit";

import PaiementList from "./../views/paiements/List";
import PaiementAdd from "./../views/paiements/AddAndEdit";

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
            component: UserAdd
        },
        {
            path: '/utilisateurs/edit/:id',
            name: 'utilisateurs.edit',
            component: UserAdd
        },

        {
            path: '/classes',
            name: 'classes',
            component: ClasseList
        },
        {
            path: '/classes/new',
            name: 'classes.add',
            component: ClasseAdd
        },
        {
            path: '/classes/edit/:id',
            name: 'classes.edit',
            component: ClasseAdd
        },
        {
            path: '/classes/infos/:id',
            name: 'classes.infos',
            component: ClasseInfo
        },

        {
            path: '/frais',
            name: 'frais',
            component: FraisList
        },
        {
            path: '/frais/new',
            name: 'frais.add',
            component: FraisAdd
        },
        {
            path: '/frais/edit/:id',
            name: 'frais.edit',
            component: FraisAdd
        },
        {
            path: '/frais/infos/:id',
            name: 'frais.infos',
            component: FraisInfo
        },

        {
            path: '/parents',
            name: 'parents',
            component: ParentList
        },
        {
            path: '/parents/new',
            name: 'parents.add',
            component: ParentAdd
        },
        {
            path: '/parents/edit/:id',
            name: 'parents.edit',
            component: ParentAdd
        },

        {
            path: '/paiements',
            name: 'paiements',
            component: PaiementList
        },
        {
            path: '/paiements/new',
            name: 'paiements.add',
            component: PaiementAdd
        },
        {
            path: '/paiements/edit/:id',
            name: 'paiements.edit',
            component: PaiementAdd
        },
    ]
});

export default router;
