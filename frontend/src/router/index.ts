import { createRouter, createWebHistory } from 'vue-router';
import Login from '@/views/Login.vue';
import Registro from '@/views/Registro.vue';
import Protected from '@/views/Protected.vue';
import ProductList from '@/views/ProductList.vue';
import ProductForm from '@/views/ProductForm.vue';
import CategoriaForm from '@/views/CategoriaForm.vue';
import Home from '@/views/Home.vue';
import ProdutosPublicos from '@/views/ProdutosPublicos.vue';
import Carrinho from '@/views/Carrinho.vue';
import Confirmacao from '@/views/Confirmacao.vue'; // <- NOVO

import { TokenService } from '@/service/TokenService';

const getUserRole = () => {
  const userData = localStorage.getItem('user');
  try {
    return userData ? JSON.parse(userData).role : null;
  } catch {
    return null;
  }
};

const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/register', name: 'Registro', component: Registro },

  // Páginas acessíveis para usuários comuns
  {
    path: '/home',
    name: 'Home',
    component: Home,
    beforeEnter: (to, from, next) => {
      if (TokenService.getToken() && getUserRole() === 'usuario') {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/produtos',
    name: 'ProdutosPublicos',
    component: ProdutosPublicos,
    beforeEnter: (to, from, next) => {
      if (TokenService.getToken() && getUserRole() === 'usuario') {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/carrinho',
    name: 'Carrinho',
    component: Carrinho,
    beforeEnter: (to, from, next) => {
      if (TokenService.getToken() && getUserRole() === 'usuario') {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/confirmacao',
    name: 'Confirmacao',
    component: Confirmacao,
    beforeEnter: (to, from, next) => {
      if (TokenService.getToken() && getUserRole() === 'usuario') {
        next();
      } else {
        next('/');
      }
    },
  },

  // Páginas restritas ao administrador
  { path: '/produto/list', name: 'ProductList', component: ProductList },
  { path: '/products/new', name: 'ProductNew', component: ProductForm },
  { path: '/categories/new', name: 'CategoryForm', component: CategoriaForm },

  // Rota protegida genérica
  {
    path: '/protected',
    name: 'Protected',
    component: Protected,
    beforeEnter: (to, from, next) => {
      if (!TokenService.getToken()) {
        next('/');
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
