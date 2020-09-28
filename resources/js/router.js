import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
// test routes
import firstPage from './components/pages/myFirstVuePage'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks'
import methods from './components/pages/basic/methods'
import home from './components/pages/home'
import usecom from './vuex/usecom'


// production routes
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import adminusers from './admin/pages/adminusers'
import role from './admin/pages/role'
import assignRole from './admin/pages/assignRole'

const routes = [
    // Project routes
    {
        path: '/',  
        component: home,
    },
    {
        path: '/tags',  
        component: tags,
    },
    {
        path: '/category',
        component: category,
    },
    {
        path: '/adminusers',
        component: adminusers,
    },
    {
        path: '/role',
        component: role,
    },
    {
        path: '/assignRole',
        component: assignRole,
    },
    
    
    
    
    // Basic tutorial routes
    {
        path: '/testvuex',
        component: usecom,
    },
    {
        path: '/my-new-vue-route',  
        component: firstPage,
    },
    {
        path: '/new-route-page',
        component: newRoutePage,
    },

    // vue hooks
    {
        path: '/hooks',
        component: hooks
    },

    // more basics
    {
        path: '/methods',
        component: methods,
    },
]

export default new Router({
    mode: 'history',
    routes,
})