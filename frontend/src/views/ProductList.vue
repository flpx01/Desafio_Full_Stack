<template>
    <div class="container mt-5">
      <h1 class="text-center mb-4">Produtos Cadastrados</h1>
      <div class="row mb-3">
        <div class="col-md-6">
          <input
            v-model="search"
            type="text"
            class="form-control"
            placeholder="Buscar por nome ou descrição"
            @input="fetchProducts"
          />
        </div>
      </div>
      <div class="row">
        <div v-if="products.length === 0" class="alert alert-info text-center">
          Nenhum produto cadastrado.
        </div>
        <div v-for="product in products" :key="product.id" class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <img
              :src="product.image || 'https://via.placeholder.com/300x200'"
              class="card-img-top"
              alt="Imagem do Produto"
              style="height: 200px; object-fit: cover;"
            />
            <div class="card-body">
              <h5 class="card-title text-truncate">{{ product.name }}</h5>
              <p class="card-text text-truncate">{{ product.description }}</p>
              <p class="card-text"><strong>R$ {{ product.price }}</strong></p>
              <div class="d-flex justify-content-between">
                <button class="btn btn-outline-primary btn-sm" @click="editProduct(product.id)">
                  Editar
                </button>
                <button class="btn btn-outline-danger btn-sm" @click="deleteProduct(product.id)">
                  Excluir
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import { ref } from 'vue';
import { getProducts, deleteProduct } from '../service/productService';

const products = ref([]);
const search = ref('');
const loading = ref(false);

async function fetchProducts(page = 1) {
  loading.value = true;
  try {
    const data = await getProducts(search.value, page);
    products.value = data.data; // Ajuste conforme o formato de resposta da API
  } catch (error) {
    alert('Erro ao buscar produtos. Tente novamente mais tarde.');
    console.error(error);
  } finally {
    loading.value = false;
  }
}

async function deleteProductHandler(id) {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    try {
      await deleteProduct(id);
      fetchProducts();
    } catch (error) {
      alert('Erro ao excluir o produto. Tente novamente mais tarde.');
      console.error(error);
    }
  }
}

// Chamada inicial para carregar os produtos
fetchProducts();
</script>

  
  <style>
  .card {
    border-radius: 10px;
  }
  .card-img-top {
    border-radius: 10px 10px 0 0;
  }
  .card-title {
    font-weight: bold;
  }
  </style>