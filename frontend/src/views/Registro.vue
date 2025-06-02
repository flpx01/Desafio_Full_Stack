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

      <label>Tipo de usuário:</label>
      <select v-model="role">
        <option value="usuario">Usuário</option>
        <option value="admin">Administrador</option>
      </select>

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
    const role = ref('usuario'); // valor padrão
    const router = useRouter();

    const registerUser = async () => {
      try {
        await api.post('/register', {
          name: name.value,
          email: email.value,
          password: password.value,
          password_confirmation: passwordConfirmation.value,
          role: role.value, // enviado ao backend
        });

        alert('Usuário registrado com sucesso!');
        router.push('/'); // redireciona para login
      } catch (error) {
        console.error('Erro ao registrar:', error);
        alert('Erro ao registrar. Verifique os dados e tente novamente.');
      }
    };

    return {
      name,
      email,
      password,
      passwordConfirmation,
      role,
      registerUser,
    };
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

.register-form input,
.register-form select {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

.register-form input:focus,
.register-form select:focus {
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
