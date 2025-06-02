<template>
  <div class="container mt-5">
    <AdminHeader />
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
    <div v-if="loading" class="text-center">
      <p>Carregando produtos...</p>
    </div>
    <div class="row">
      <div v-if="!loading && products.length === 0" class="alert alert-info text-center">
        Nenhum produto cadastrado.
      </div>
      <div
        v-for="product in products"
        :key="product.id"
        class="col-md-4 mb-4"
      >
        <div class="card shadow-sm h-100">
          <img
            v-if="product.imagem"
            :src="product.imagem"
            class="card-img-top"
            alt="Imagem do Produto"
            style="height: 200px; object-fit: cover;"
          />
          <div class="card-body">
            <h5 class="card-title text-truncate">{{ product.nome }}</h5>
            <p class="card-text text-truncate">{{ product.descricao }}</p>
            <p class="card-text"><strong>R$ {{ product.preco }}</strong></p>
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-primary btn-sm" @click="openEditModal(product)">
                Editar
              </button>
              <button class="btn btn-outline-danger btn-sm" @click="deleteProductHandler(product.id)">
                Excluir
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div
      v-if="showEditModal"
      class="modal fade show"
      style="display: block; background-color: rgba(0, 0, 0, 0.5);"
      tabindex="-1"
      role="dialog"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Produto</h5>
            <button type="button" class="btn-close" @click="closeEditModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitEditForm">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input v-model="selectedProduct.nome" type="text" id="nome" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea v-model="selectedProduct.descricao" id="descricao" class="form-control" required></textarea>
              </div>
              <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input v-model="selectedProduct.preco" type="number" id="preco" class="form-control" min="0" step="0.01" required />
              </div>
              <div class="mb-3">
                <label for="data_validade" class="form-label">Data de Validade</label>
                <input v-model="selectedProduct.data_validade" type="date" id="data_validade" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" id="imagem" class="form-control" @change="handleImageUpload" />
                <img v-if="selectedProduct.imagem && !imageFile" :src="selectedProduct.imagem" class="img-thumbnail mt-2" style="max-width: 200px;" />
                <img v-if="imageFile" :src="previewImage" class="img-thumbnail mt-2" style="max-width: 200px;" />
              </div>
              <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoria</label>
                <input v-model="selectedProduct.categoria_id" type="number" id="categoria_id" class="form-control" required />
              </div>
              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { getProducts, deleteProduct, updateProduct } from '../service/productService';
import AdminHeader from '@/components/AdminHeader.vue';

const products = ref([]);
const search = ref('');
const loading = ref(false);
const showEditModal = ref(false); // Controla a exibição do modal
const selectedProduct = ref({}); // Armazena os dados do produto selecionado para edição
const imageFile = ref(null); // Armazena o arquivo de imagem selecionado
const previewImage = ref(null); // Pré-visualização da nova imagem

async function fetchProducts(page = 1) {
  loading.value = true;
  try {
    const data = await getProducts(search.value, page);
    products.value = data || [];
  } catch (error) {
    alert('Erro ao buscar produtos. Tente novamente mais tarde.');
    console.error(error);
  } finally {
    loading.value = false;
  }
}

function openEditModal(product) {
  selectedProduct.value = { ...product }; // Clona os dados do produto selecionado
  previewImage.value = null; // Reseta a pré-visualização
  imageFile.value = null; // Reseta o arquivo de imagem
  showEditModal.value = true;
}

function closeEditModal() {
  showEditModal.value = false;
  selectedProduct.value = {};
  imageFile.value = null; // Reseta o arquivo de imagem ao fechar o modal
  previewImage.value = null; // Reseta a pré-visualização
}

function handleImageUpload(event) {
  const file = event.target.files[0];
  if (file && file.type.startsWith('image/')) {
    imageFile.value = file;
    previewImage.value = URL.createObjectURL(file); // Atualiza a pré-visualização
  } else {
    alert('Por favor, selecione um arquivo de imagem válido.');
  }
}

async function submitEditForm() {
  try {
    const formData = new FormData();

    // Adiciona os valores do produto no FormData
    Object.entries(selectedProduct.value).forEach(([key, value]) => {
      if (value !== null && value !== undefined && key !== 'imagem') {
        formData.append(key, String(value));
      }
    });

    // Adiciona a imagem apenas se um novo arquivo foi selecionado
    if (imageFile.value) {
      formData.append('imagem', imageFile.value);
    }

    await updateProduct(selectedProduct.value.id, formData);
    alert('Produto atualizado com sucesso!');
    closeEditModal();
    fetchProducts(); // Recarrega a lista de produtos
  } catch (error) {
    alert('Erro ao atualizar o produto. Tente novamente mais tarde.');
    console.error(error);
  }
}

async function deleteProductHandler(productId) {
  try {
    const confirmDelete = confirm('Tem certeza que deseja excluir este produto?');
    if (confirmDelete) {
      await deleteProduct(productId);
      alert('Produto excluído com sucesso!');
      fetchProducts(); // Atualiza a lista após a exclusão
    }
  } catch (error) {
    alert('Erro ao excluir o produto. Tente novamente mais tarde.');
    console.error(error);
  }
}

// Chamada inicial para carregar os produtos
fetchProducts();
</script>

<style scoped>
.img-thumbnail {
  max-width: 200px;
  height: auto;
}
</style>