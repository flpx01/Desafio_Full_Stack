import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [] as Array<{ id: number; nome: string; preco: number; quantidade: number }>,
    ultimaCompra: {
      produtos: [] as Array<{ id: number; nome: string; preco: number; quantidade: number }>,
      total: 0,
    },
  }),

  actions: {
    // Adiciona ou incrementa um produto no carrinho
    addToCart(produto: { id: number; nome: string; preco: number }) {
      const item = this.items.find(p => p.id === produto.id);
      if (item) {
        item.quantidade += 1;
      } else {
        this.items.push({ ...produto, quantidade: 1 });
      }
    },

    // Remove completamente um item do carrinho
    removeFromCart(id: number) {
      this.items = this.items.filter(p => p.id !== id);
    },

    // Limpa o carrinho todo
    clearCart() {
      this.items = [];
    },

    // Incrementa a quantidade de um produto específico
    incrementarQuantidade(id: number) {
      const item = this.items.find(p => p.id === id);
      if (item) {
        item.quantidade += 1;
      }
    },

    // Decrementa a quantidade ou remove se for 1
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

    // Finaliza a compra: salva os dados e limpa o carrinho
    finalizarCompra() {
      this.ultimaCompra.produtos = [...this.items];
      this.ultimaCompra.total = this.items.reduce(
        (sum, item) => sum + item.preco * item.quantidade,
        0
      );
      this.clearCart();
    },
  },
});
