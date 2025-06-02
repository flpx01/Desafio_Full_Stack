<template>
    <div class="container mt-5">
      <UserHeader />
      <h2 class="mb-4 text-center">Carrinho de Compras</h2>
  
      <table class="table table-hover table-bordered text-center">
        <thead class="table-primary">
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Total</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cart.items" :key="item.id">
            <td>{{ item.nome }}</td>
            <td>{{ item.quantidade }}</td>
            <td>R$ {{ item.preco.toFixed(2) }}</td>
            <td>R$ {{ (item.preco * item.quantidade).toFixed(2) }}</td>
            <td>
              <button class="btn btn-sm btn-outline-success me-1" @click="incrementar(item.id)">+</button>
              <button class="btn btn-sm btn-outline-warning me-1" @click="decrementar(item.id)" v-if="item.quantidade > 1">-</button>
              <button class="btn btn-sm btn-outline-danger" @click="remover(item.id)" v-else>Remover</button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <h4 class="text-end mt-4">Total: R$ {{ total.toFixed(2) }}</h4>
  
      <div class="text-end mt-3">
        <button class="btn btn-primary" @click="mostrarModalForma = true" :disabled="cart.items.length === 0">
          Finalizar Compra
        </button>
      </div>
  
      <!-- Modal Selecionar Forma de Pagamento -->
      <div v-if="mostrarModalForma" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Escolha a Forma de Pagamento</h5>
              <button type="button" class="btn-close" @click="mostrarModalForma = false"></button>
            </div>
            <div class="modal-body text-center">
              <button class="btn btn-outline-success me-2" @click="formaSelecionada('pix')">Pix</button>
              <button class="btn btn-outline-primary" @click="formaSelecionada('cartao')">Cartão</button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal Pix -->
      <div v-if="mostrarModalPix" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Pagamento via Pix</h5>
              <button type="button" class="btn-close" @click="mostrarModalPix = false"></button>
            </div>
            <div class="modal-body text-center">
              <p>Escaneie o código abaixo com seu app de banco:</p>
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PagamentoMixoline" alt="QR Code Pix">
              <p class="mt-3">Total: <strong>R$ {{ total.toFixed(2) }}</strong></p>
              <button class="btn btn-success mt-3" @click="confirmarCompra('Pix')">Confirmar Pagamento</button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal Cartão com tipo de pagamento -->
      <div v-if="mostrarModalCartao" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Pagamento com Cartão</h5>
              <button type="button" class="btn-close" @click="mostrarModalCartao = false"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="confirmarCompra('Cartão ' + cartao.tipo)">
                <div class="mb-3">
                  <label class="form-label">Nome no Cartão</label>
                  <input type="text" class="form-control" v-model="cartao.nome" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">Número do Cartão</label>
                  <input type="text" class="form-control" v-model="cartao.numero" required />
                </div>
                <div class="row mb-3">
                  <div class="col">
                    <label class="form-label">Validade</label>
                    <input type="month" class="form-control" v-model="cartao.validade" required />
                  </div>
                  <div class="col">
                    <label class="form-label">CVV</label>
                    <input type="text" class="form-control" v-model="cartao.cvv" required />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tipo de Pagamento</label>
                  <select class="form-select" v-model="cartao.tipo" required>
                    <option value="crédito">Crédito</option>
                    <option value="débito">Débito</option>
                  </select>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script lang="ts" setup>
  import { useCartStore } from '@/stores/cartStore';
  import { computed, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import UserHeader from '@/components/UserHeader.vue';
  
  const cart = useCartStore();
  const total = computed(() => cart.items.reduce((sum, item) => sum + item.preco * item.quantidade, 0));
  
  const mostrarModalForma = ref(false);
  const mostrarModalPix = ref(false);
  const mostrarModalCartao = ref(false);
  
  const cartao = ref({ nome: '', numero: '', validade: '', cvv: '', tipo: 'crédito' });
  
  const incrementar = (id: number) => cart.incrementarQuantidade(id);
  const decrementar = (id: number) => cart.decrementarQuantidade(id);
  const remover = (id: number) => cart.removeFromCart(id);
  
  const formaSelecionada = (forma: string) => {
    mostrarModalForma.value = false;
    if (forma === 'pix') mostrarModalPix.value = true;
    else if (forma === 'cartao') mostrarModalCartao.value = true;
  };
  
  const router = useRouter();
  
  const confirmarCompra = () => {
  cart.finalizarCompra();
  mostrarModalPix.value = false;
  mostrarModalCartao.value = false;
  router.push('/confirmacao');
};
  </script>
  
  <style scoped>
  .table th,
  .table td {
    vertical-align: middle;
  }
  .btn {
    min-width: 32px;
  }
  .modal.fade.show {
    display: block;
  }
  </style>
  