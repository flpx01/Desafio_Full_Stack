<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <router-link class="navbar-brand fw-bold" to="/produto/list">Painel Admin</router-link>
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <router-link class="nav-link" to="/produto/list">Produtos</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/products/new">Novo Produto</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/categories/new">Nova Categoria</router-link>
      </li>
    </ul>
    <div class="d-flex align-items-center">
      <span class="me-3">Admin: {{ nomeAdmin }}</span>
      <button class="btn btn-outline-danger btn-sm" @click="logout">Sair</button>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { TokenService } from '@/service/TokenService';

const nomeAdmin = ref('Administrador');
const router = useRouter();

onMounted(() => {
  const user = localStorage.getItem('user');
  if (user) {
    try {
      const parsed = JSON.parse(user);
      nomeAdmin.value = parsed.name || 'Administrador';
    } catch {
      nomeAdmin.value = 'Administrador';
    }
  }
});

function logout() {
  TokenService.clearToken();
  localStorage.removeItem('user');
  router.push('/');
}
</script>
