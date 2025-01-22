import api from '../api';
import { TokenService } from './TokenService';

export interface Produto {
  id?: number;
  nome: string;
  descricao: string;
  preco: number;
  data_validade: string;
  imagem: File | string;
  categoria_id: number;
}

const getAuthHeaders = () => {
  const token = TokenService.getToken();
  return {
    Authorization: token,
  };
};

export const getProducts = async (search = '', page = 1): Promise<Produto[]> => {
  try {
    const response = await api.get('/produtos', {
      headers: getAuthHeaders(),
      params: { search, page },
    });
    return response.data.data.data || []; // Corrigido para acessar os produtos na resposta paginada
  } catch (error) {
    console.error('Erro ao buscar produtos:', error);
    throw new Error('Não foi possível buscar os produtos.');
  }
};

export const getProductById = async (id: number): Promise<Produto> => {
  try {
    const response = await api.get(`/produtos/${id}`, {
      headers: getAuthHeaders(),
    });
    return response.data;
  } catch (error) {
    console.error('Erro ao buscar produto:', error);
    throw new Error(`Não foi possível buscar o produto com ID ${id}.`);
  }
};

// Ajustado para aceitar FormData
export const createProduct = async (formData: FormData): Promise<Produto> => {
  try {
    const response = await api.post('/produtos', formData, {
      headers: {
        ...getAuthHeaders(),
        'Content-Type': 'multipart/form-data',
      },
    });
    return response.data;
  } catch (error) {
    console.error('Erro ao criar produto:', error);
    throw new Error('Não foi possível criar o produto.');
  }
};

// Ajustado para aceitar FormData
export const updateProduct = async (id: number, formData: FormData): Promise<Produto> => {
  try {
    const response = await api.put(`/produtos/${id}`, formData, {
      headers: {
        ...getAuthHeaders(),
        'Content-Type': 'multipart/form-data',
      },
    });
    return response.data;
  } catch (error) {
    console.error('Erro ao atualizar produto:', error);
    throw new Error(`Não foi possível atualizar o produto com ID ${id}.`);
  }
};

export const deleteProduct = async (id: number): Promise<void> => {
  try {
    await api.delete(`/produtos/${id}`, {
      headers: getAuthHeaders(),
    });
  } catch (error) {
    console.error('Erro ao excluir produto:', error);
    throw new Error(`Não foi possível excluir o produto com ID ${id}.`);
  }
};
