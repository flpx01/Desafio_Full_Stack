<template>
  <div class="register-container">
    <h2>Registrar Usuário</h2>
    <form class="register-form" @submit.prevent="registerUser">
      <label>Nome:</label>
      <input v-model="name" type="text" placeholder="Digite seu nome" required />
      
      <label>Email:</label>
      <input v-model="email" type="email" placeholder="Digite seu email" required />
      
      <label>Senha:</label>
      <input v-model="password" type="password" placeholder="Digite sua senha" required />
      
      <label>Confirme a Senha:</label>
      <input
        v-model="passwordConfirmation"
        type="password"
        placeholder="Confirme sua senha"
        required
      />
      
      <button type="submit" class="register-button">Registrar</button>
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
        router.push('/'); // Redireciona para a tela de login
      } catch (error) {
        console.error(error);
      }
    };

    return { name, email, password, passwordConfirmation, registerUser };
  },
});
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.register-form {
  display: flex;
  flex-direction: column;
}

.register-form label {
  margin-bottom: 5px;
  font-weight: bold;
  color: #555;
}

.register-form input {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

.register-form input:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
}

.register-button {
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.register-button:hover {
  background-color: #0056b3;
}

.register-button:focus {
  outline: none;
  box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
}
</style>