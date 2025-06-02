<template>
    <div>
      <!-- Cabeçalho padrão do usuário -->
      <UserHeader />
  
      <!-- Carrossel de Destaques -->
      <div id="carouselPromo" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#carouselPromo" data-bs-slide-to="2"></button>
        </div>
  
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img :src="banner1" class="d-block w-100" alt="Promoção 1" />
            <div class="carousel-caption d-none d-md-block">
              <h5>Super Desconto de Lançamento</h5>
              <p>Aproveite até 30% OFF em Hortifrutis selecionados!</p>
              <router-link to="/produtos" class="btn btn-carousel mt-2">
                Ver Ofertas
              </router-link>
            </div>
          </div>
          <div class="carousel-item">
            <img :src="banner2" class="d-block w-100" alt="Promoção 2" />
            <div class="carousel-caption d-none d-md-block">
              <h5>Medicamentos em Oferta</h5>
              <p>Genéricos com preços especiais.</p>
              <router-link to="/produtos" class="btn btn-carousel mt-2">
                Ver Produtos
              </router-link>
            </div>
          </div>
          <div class="carousel-item">
            <img :src="banner3" class="d-block w-100" alt="Promoção 3" />
            <div class="carousel-caption d-none d-md-block">
              <h5>Assistência Técnica Premium</h5>
              <p>Conserto rápido e garantido para todos os consoles.</p>
              <router-link to="/produtos" class="btn btn-carousel mt-2">
                Saiba Mais
              </router-link>
            </div>
          </div>
        </div>
  
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
  
      <!-- Hero Section -->
      <section class="hero-section text-white text-center py-5">
        <div class="container">
          <h1 class="display-4 fw-bold">Bem-vindo à MixOnline</h1>
          <p class="lead">"Tudo o que você procura em um só lugar: qualidade, variedade e preços que cabem no seu bolso."</p>
          <router-link to="/produtos" class="btn btn-outline-light btn-lg mt-3">
            Ver Produtos
          </router-link>
        </div>
      </section>
  
      <!-- Ofertas Especiais -->
      <section class="container my-5">
        <h2 class="text-center mb-4">Ofertas Especiais</h2>
        <div class="row g-4">
          <div class="col-md-4" v-for="(oferta, index) in ofertas" :key="index">
            <div class="card h-100 shadow-sm">
              <img :src="oferta.imagem" class="card-img-top" alt="Promoção" />
              <div class="card-body">
                <h5 class="card-title">{{ oferta.titulo }}</h5>
                <p class="card-text">{{ oferta.descricao }}</p>
                <router-link to="/produtos" class="btn btn-outline-primary w-100">
                  Ver agora
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Sobre a Loja -->
      <section class="bg-light py-5">
        <div class="container">
          <h2 class="text-center mb-4">Sobre a MixOnline</h2>
          <p class="text-center fs-5">
            "Na Mixoline, somos apaixonados por inovação, praticidade e bem-estar. Desde 2015, oferecemos uma ampla variedade de produtos de qualidade — de tecnologia a utilidades do dia a dia — sempre com preços acessíveis e atendimento de confiança. Aqui, você encontra tudo o que precisa para tornar sua rotina mais prática e completa."
          </p>
        </div>
      </section>
  
      <!-- Vantagens -->
      <section class="container my-5">
        <h2 class="text-center mb-4">Por que escolher a gente?</h2>
        <div class="row g-4">
          <div class="col-md-4 text-center">
            <i class="bi bi-controller display-4 text-primary"></i>
            <h5 class="mt-3">Variedade de Produtos</h5>
            <p>Temos as últimas gerações de consoles e Produtos originais.</p>
          </div>
          <div class="col-md-4 text-center">
            <i class="bi bi-tools display-4 text-success"></i>
            <h5 class="mt-3">Assistência Técnica</h5>
            <p>Equipe técnica especializada para consertos rápidos e seguros.</p>
          </div>
          <div class="col-md-4 text-center">
            <i class="bi bi-currency-dollar display-4 text-warning"></i>
            <h5 class="mt-3">Preços Imbatíveis</h5>
            <p>Ofertas imperdíveis e parcelamento facilitado em até 12x.</p>
          </div>
        </div>
      </section>
  
      <!-- Avaliações -->
      <section class="bg-light py-5">
        <div class="container">
          <h2 class="text-center mb-4">O que dizem nossos clientes</h2>
          <div class="row g-4 justify-content-center">
            <div class="col-md-4" v-for="(cliente, index) in avaliacoes" :key="index">
              <div class="card h-100 p-3 shadow-sm">
                <p class="mb-2 fst-italic">"{{ cliente.comentario }}"</p>
                <div class="text-end">
                  <strong>- {{ cliente.nome }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Rodapé -->
      <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
          <p class="mb-0">&copy; 2025 MixOnline. Todos os direitos reservados.</p>
        </div>
      </footer>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import UserHeader from '@/components/UserHeader.vue';
  import banner1 from '@/assets/banner1.webp';
  import banner2 from '@/assets/banner2.webp';
  import banner3 from '@/assets/banner3.avif';
  import xbox from '@/assets/xbox.jpeg';
  import rivotril from '@/assets/rivotril.jpeg';
  import generico from '@/assets/download.jpeg';
  
  export default defineComponent({
    components: { UserHeader },
    setup() {
      const avaliacoes = [
        { nome: 'Lucas M.', comentario: 'Comprei meu PS5 e chegou em 2 dias! Excelente loja!' },
        { nome: 'Amanda R.', comentario: 'Atendimento técnico de primeira. Voltarei com certeza.' },
        { nome: 'Carlos T.', comentario: 'Os melhores preços e ótimas promoções!' },
      ];
  
      const ofertas = [
        {
          imagem: xbox,
          titulo: 'Xbox Series S em Promoção',
          descricao: 'Desconto especial para gamers apaixonados!',
        },
        {
          imagem: rivotril,
          titulo: 'Rivotril Genérico',
          descricao: 'Mais barato e com a mesma qualidade do original.',
        },
        {
          imagem: generico,
          titulo: 'Frutas em Oferta',
          descricao: 'Diversas Frutas e verduras com preços acessíveis.',
        },
      ];
  
      return { banner1, banner2, banner3, avaliacoes, ofertas };
    },
  });
  </script>
  
  <style scoped>
  .hero-section {
    background-color: #007bff;
    min-height: 300px;
    display: flex;
    align-items: center;
    color: white;
  }
  .card-title {
    font-weight: bold;
  }
  .carousel-item img {
    max-height: 400px;
    object-fit: cover;
  }
  .carousel-caption {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 1rem;
    border-radius: 8px;
  }
  .carousel-indicators button {
    background-color: #fff;
  }
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
  }
  .btn-carousel {
    background-color: #0d6efd;
    color: #fff;
    border: none;
    padding: 0.6rem 1.2rem;
    font-weight: bold;
    border-radius: 0.4rem;
    opacity: 1;
    transition: background-color 0.3s ease;
  }
  .btn-carousel:hover {
    background-color: #0b5ed7;
    color: #fff;
  }
  </style>
  