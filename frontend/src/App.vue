<template>
  <div id="app">
    <header class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Minha Loja</a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" to="/">Lista de Produtos</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/products/new">Cadastrar Produto</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/categories/new">Cadastrar Categoria</router-link>
        </li>
      </ul>
    </header>
    <main class="container mt-4">
      <router-view />
    </main>
  </div>
</template>

<script setup>
</script>
