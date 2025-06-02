<template>
  <div class="login-container">
    <h2>Login</h2>
    <form class="login-form" @submit.prevent="loginUser">
      <label>Email:</label>
      <input v-model="email" type="email" placeholder="Digite seu email" required />

      <label>Senha:</label>
      <input v-model="password" type="password" placeholder="Digite sua senha" required />

      <button type="submit" class="login-button">Login</button>
    </form>

    <div class="redirect-container">
      <p>Não possui uma conta?</p>
      <button class="register-button" @click="goToRegister">Registrar-se</button>
    </div>
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
        // Envia login e recebe token + dados do usuário
        const response = await api.post('/login', {
          email: email.value,
          password: password.value,
        });

        const token = response.data.token;
        const user = response.data.user;

        // Salva token e dados do usuário
        TokenService.saveToken(token);
        localStorage.setItem('user', JSON.stringify(user));

        alert('Login realizado com sucesso!');

        // Redireciona com base no tipo de usuário
        if (user.role === 'admin') {
          router.push('/products/new');
        } else {
          router.push('/home');
        }

      } catch (error) {
        console.error('Erro no login:', error);
        alert('Email ou senha inválidos.');
      }
    };

    const goToRegister = () => {
      router.push('/register');
    };

    return {
      email,
      password,
      loginUser,
      goToRegister,
    };
  },
});
</script>

<style scoped>
/* (estilo inalterado, mantido como no seu código anterior) */
.login-container {
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

.login-form {
  display: flex;
  flex-direction: column;
}

.login-form label {
  margin-bottom: 5px;
  font-weight: bold;
  color: #555;
}

.login-form input {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

.login-form input:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
}

.login-button {
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.login-button:hover {
  background-color: #0056b3;
}

.login-button:focus {
  outline: none;
  box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
}

.redirect-container {
  text-align: center;
  margin-top: 20px;
}

.register-button {
  padding: 8px 12px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.register-button:hover {
  background-color: #218838;
}

.register-button:focus {
  outline: none;
  box-shadow: 0 0 3px rgba(40, 167, 69, 0.5);
}
</style>
