<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="loginUser">
        <label>Email:</label>
        <input v-model="email" type="email" required />
        <label>Senha:</label>
        <input v-model="password" type="password" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import api from '@/api';
  import { TokenService } from '@/service/TokenService';
  
  export default defineComponent({
    setup() {
      const email = ref('');
      const password = ref('');
      const router = useRouter();
  
      const loginUser = async () => {
        try {
          const response = await api.post('/login', {
            email: email.value,
            password: password.value,
          });
          TokenService.saveToken(response.data.token);
          alert('Login realizado com sucesso!');
          router.push('/'); // Redireciona para a tela da lista de produtos
        } catch (error) {
          console.error(error);
        }
      };
  
      return { email, password, loginUser };
    },
  });
  </script>