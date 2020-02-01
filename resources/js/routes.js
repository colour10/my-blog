// 引入Vue-router
import VueRouter from "vue-router";
// component采用组件方式引入
import Home from './components/pages/Home';
import About from './components/pages/About';
import Info from './components/infos/Info';

// 定义Routes
let routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/about',
        component: About
    },
    {
        name: 'infos',
        path: '/infos/:id',
        component: Info
    }
];

// 导出默认模块
export default new VueRouter({
    // 去掉url后面的#
    mode: 'history',
    routes
});
