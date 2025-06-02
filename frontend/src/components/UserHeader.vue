<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
      <router-link class="navbar-brand" to="/home">Mixoline</router-link>
  
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/home">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/produtos">Produtos</router-link>
          </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/carrinho">Carrinho</router-link>
                </li>
        </ul>
  
        <div class="d-flex align-items-center">
          <span class="text-white me-3">Olá, {{ nomeUsuario }}</span>
          <button class="btn btn-outline-light btn-sm" @click="logout">Sair</button>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import { TokenService } from '@/service/TokenService';
  
  const router = useRouter();
  const nomeUsuario = ref('Usuário');
  
  onMounted(() => {
    const user = localStorage.getItem('user');
    if (user) {
      try {
        const parsed = JSON.parse(user);
        nomeUsuario.value = parsed.name || 'Usuário';
      } catch {
        nomeUsuario.value = 'Usuário';
      }
    }
  });
  
  function logout() {
    TokenService.clearToken();
    localStorage.removeItem('user');
    router.push('/');
  }
  </script>
  