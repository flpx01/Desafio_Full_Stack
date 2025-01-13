<template>
    <div>
      <h1>Bem-vindo à Rota Protegida</h1>
      <p>Você só pode acessar esta página porque está autenticado.</p>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'ProtectedView',
  });
  </script>
  
  <style scoped>
  h1 {
    color: #4caf50;
  }
  p {
    font-size: 1.2em;
  }
  </style>
  