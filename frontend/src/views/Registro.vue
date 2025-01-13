<template>
    <div>
      <h2>Registrar Usuário</h2>
      <form @submit.prevent="registerUser">
        <label>Nome:</label>
        <input v-model="name" required />
        <label>Email:</label>
        <input v-model="email" type="email" required />
        <label>Senha:</label>
        <input v-model="password" type="password" required />
        <label>Confirme a Senha:</label>
        <input v-model="passwordConfirmation" type="password" required />
        <button type="submit">Registrar</button>
      </form>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import api from '@/api';
  
  export default defineComponent({
    setup() {
      const name = ref('');
      const email = ref('');
      const password = ref('');
      const passwordConfirmation = ref('');
      const router = useRouter();
  
      const registerUser = async () => {
        try {
          await api.post('/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
          });
          alert('Usuário registrado com sucesso!');
          router.push('/login'); // Redireciona para a tela de login
        } catch (error) {
          console.error(error);
        }
      };
  
      return { name, email, password, passwordConfirmation, registerUser };
    },
  });
  </script>
