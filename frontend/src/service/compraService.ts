import api from '../api';
import { TokenService } from './TokenService';

export interface ItemCompra {
  produto_id: number;
  quantidade: number;
  preco: number;
}

export interface NovaCompra {
  total: number;
  forma_pagamento: string;
  itens: ItemCompra[];
}

// Cabeçalhos com token
const getAuthHeaders = () => {
  const token = TokenService.getToken();
  return {
    Authorization: token,
  };
};

// Registrar nova compra
export const registrarCompra = async (compra: NovaCompra): Promise<any> => {
  try {
    const response = await api.post('/compras', compra, {
      headers: getAuthHeaders(),
    });

    return response.data; // O backend retorna { success, message, compra_id }
  } catch (error: any) {
    console.error('Erro ao registrar compra:', error.response?.data || error.message);
    throw new Error('Não foi possível registrar a compra.');
  }
};
