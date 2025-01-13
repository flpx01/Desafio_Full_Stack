<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-header bg-primary text-white">
              <h4 class="mb-0">Cadastrar Categoria</h4>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="mb-3">
                  <label for="name" class="form-label">Nome da Categoria</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="category.nome"
                    placeholder="Digite o nome da categoria"
                    required
                  />
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-success">Cadastrar Categoria</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import api from '@/api';
  
  const category = ref({ nome: '' });
  
  async function submitForm() {
    try {
      await api.post('/categorias', category.value, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('authToken')}`,
        },
      });
      alert('Categoria cadastrada com sucesso!');
      category.value.nome = ''; // Limpa o formulário
    } catch (error) {
      alert('Erro ao cadastrar categoria. Verifique os dados e tente novamente.');
      console.error(error);
    }
  }
  </script>
  
  <style scoped>
  .card {
    border-radius: 10px;
  }
  .card-header {
    border-radius: 10px 10px 0 0;
  }
  </style>
  