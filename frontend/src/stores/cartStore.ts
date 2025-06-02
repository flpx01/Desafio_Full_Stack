import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [] as Array<{ id: number; nome: string; preco: number; quantidade: number }>,
    ultimaCompra: {
      produtos: [] as Array<{ id: number; nome: string; preco: number; quantidade: number }>,
      total: 0,
      forma_pagamento: '',
    },
  }),

  getters: {
    // Gera estrutura adequada para o backend
    itensParaEnvio(state) {
      return state.items.map(item => ({
        produto_id: item.id,
        quantidade: item.quantidade,
        preco: item.preco,
      }));
    },
  },

  actions: {
    // Adiciona um produto ao carrinho
    addToCart(produto: { id: number; nome: string; preco: number }) {
      const item = this.items.find(p => p.id === produto.id);
      if (item) {
        item.quantidade += 1;
      } else {
        this.items.push({ ...produto, quantidade: 1 });
      }
    },

    // Remove um item do carrinho
    removeFromCart(id: number) {
      this.items = this.items.filter(p => p.id !== id);
    },

    // Limpa o carrinho
    clearCart() {
      this.items = [];
    },

    // Incrementa a quantidade de um item
    incrementarQuantidade(id: number) {
      const item = this.items.find(p => p.id === id);
      if (item) item.quantidade += 1;
    },

    // Decrementa a quantidade ou remove
    decrementarQuantidade(id: number) {
      const item = this.items.find(p => p.id === id);
      if (item) {
        if (item.quantidade > 1) {
          item.quantidade -= 1;
        } else {
          this.removeFromCart(id);
        }
      }
    },

    // Salva os dados da última compra e limpa carrinho
    finalizarCompra(forma_pagamento?: string) {
      this.ultimaCompra.produtos = [...this.items];
      this.ultimaCompra.total = this.items.reduce(
        (sum, item) => sum + item.preco * item.quantidade,
        0
      );
      if (forma_pagamento) {
        this.ultimaCompra.forma_pagamento = forma_pagamento;
      }
      this.clearCart();
    },
  },
});
