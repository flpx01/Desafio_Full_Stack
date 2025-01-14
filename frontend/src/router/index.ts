import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/views/Login.vue';
import Registro from '@/views/Registro.vue';
import Protected from '@/views/Protected.vue';
import ProductList from '@/views/ProductList.vue';
import ProductForm from '@/views/ProductForm.vue';
import { TokenService } from '@/service/TokenService';
import CategoriaForm from '@/views/CategoriaForm.vue';

const routes = [
  { path: '/produto/list', name: 'ProductList', component: ProductList },
  { path: '/products/new', name: 'ProductNew', component: ProductForm },
  {path: '/categories/new', name: 'CategoryForm', component: CategoriaForm },
  { path: '/', name: 'Login', component: Login },
  { path: '/register', name: 'Registro', component: Registro },
  {
    path: '/protected',
    name: 'Protected',
    component: Protected,
    beforeEnter: (to, from, next) => {
      if (!TokenService.getToken()) {
        next('/login');
      } else {
        next();
      }
    },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
