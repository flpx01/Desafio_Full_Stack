<template>
    <div class="container mt-5" ref="comprovanteRef">
      <UserHeader />
      <h2 class="text-center mb-4">Compra Confirmada!</h2>
      <p class="text-center">Obrigado por comprar na Mixoline. Aqui está o resumo da sua compra:</p>
  
      <table class="table table-bordered mt-4">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in compra.produtos" :key="item.id">
            <td>{{ item.nome }}</td>
            <td>{{ item.quantidade }}</td>
            <td>R$ {{ item.preco.toFixed(2) }}</td>
            <td>R$ {{ (item.preco * item.quantidade).toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>
  
      <h4 class="text-end mt-3">Total: R$ {{ compra.total.toFixed(2) }}</h4>
  
      <div class="text-center mt-4">
        <button class="btn btn-success" @click="gerarComprovantePDF">
          Baixar Comprovante
        </button>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import UserHeader from '@/components/UserHeader.vue';
  import { useCartStore } from '@/stores/cartStore';
  import html2pdf from 'html2pdf.js';
  
  const cart = useCartStore();
  const compra = cart.ultimaCompra;
  
  const comprovanteRef = ref<HTMLElement | null>(null);
  
  const gerarComprovantePDF = () => {
    if (comprovanteRef.value) {
      html2pdf()
        .from(comprovanteRef.value)
        .set({
          margin: 10,
          filename: 'comprovante_mixoline.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        })
        .save();
    }
  };
  </script>
  
  <style scoped>
  .table th,
  .table td {
    vertical-align: middle;
  }
  </style>
  