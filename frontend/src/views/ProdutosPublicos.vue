<template>
    <div>
      <UserHeader />
  
      <div class="container mt-5">
        <h2 class="mb-4 text-center">Produtos disponíveis</h2>
  
        <div class="mb-4 text-center">
          <label class="form-label me-2">Filtrar por categoria:</label>
          <select class="form-select w-auto d-inline" v-model="categoriaSelecionada">
            <option value="">Todas</option>
            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
              {{ categoria.nome }}
            </option>
          </select>
        </div>
  
        <div v-if="loading" class="text-center mb-3">
          <p>Carregando produtos...</p>
        </div>
  
        <div class="row g-4">
          <div
            v-for="produto in produtosFiltrados"
            :key="produto.id"
            class="col-md-4 d-flex align-items-stretch"
          >
            <div class="card shadow w-100">
              <img
                v-if="produto.imagem"
                :src="produto.imagem"
                class="card-img-top"
                alt="Imagem do produto"
                style="height: 200px; object-fit: cover;"
              />
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ produto.nome }}</h5>
                <p class="card-text">{{ produto.descricao }}</p>
                <p class="card-text fw-bold text-primary">
                  R$ {{ produto.preco ? Number(produto.preco).toFixed(2) : '0.00' }}
                </p>
                <span class="badge bg-secondary mb-3">
                  {{ produto.categoria?.nome || 'Sem categoria' }}
                </span>
                <button class="btn btn-success mt-auto">Comprar</button>
              </div>
            </div>
          </div>
          <div v-if="!loading && produtosFiltrados.length === 0" class="text-center">
            <p>Nenhum produto disponível.</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted, computed } from 'vue';
  import { getProducts } from '@/service/productService';
  import api from '@/api';
  import UserHeader from '@/components/UserHeader.vue';
  
  const produtos = ref<any[]>([]);
  const categorias = ref<any[]>([]);
  const categoriaSelecionada = ref('');
  const loading = ref(false);
  
  const carregarDados = async () => {
    loading.value = true;
    try {
      const data = await getProducts();
      produtos.value = data;
  
      const response = await api.get('/categorias');
      categorias.value = response.data.data;
    } catch (error) {
      console.error('Erro ao carregar produtos ou categorias:', error);
    } finally {
      loading.value = false;
    }
  };
  
  const produtosFiltrados = computed(() => {
    if (!categoriaSelecionada.value) return produtos.value;
    return produtos.value.filter(
      (produto) => produto.categoria_id === parseInt(categoriaSelecionada.value)
    );
  });
  
  onMounted(() => {
    carregarDados();
  });
  </script>
  
  <style scoped>
  .card-title {
    font-size: 18px;
    font-weight: bold;
  }
  
  .card-text {
    font-size: 14px;
  }
  
  .badge {
    font-size: 12px;
  }
  
  .btn-success {
    width: 100%;
  }
  </style>
  