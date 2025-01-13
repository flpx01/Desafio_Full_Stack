#Desafio Full_Stack

# README - Frontend VueJS 3 com TypeScript

## Descrição

Este é o frontend de uma aplicação VueJS 3 com TypeScript, configurado para rodar com comandos Node de desenvolvimento. A aplicação utiliza o Vue 3 para criar interfaces reativas e TypeScript para garantir uma melhor qualidade de código e facilitar o desenvolvimento com tipagem estática.

---

## Requisitos

Antes de começar, certifique-se de que os seguintes pré-requisitos estão instalados:

- *Node.js* (versão 16 ou superior)  
  Para verificar a versão do Node.js instalada, utilize o comando:
  bash
  node -v


---

1. *Acesse a pasta do frontend:*
   Primeiro, abra o terminal ou prompt de comando e navegue até a pasta frontend. Use o comando:
 
   cd frontend
   
   Certifique-se de estar na raiz do repositório antes de executar este comando.

---

2. *Verifique o arquivo package.json:*
   Confirme que existe um arquivo chamado package.json na pasta frontend. Esse arquivo contém informações sobre as dependências e scripts do projeto.

   Para verificar, use:
  
   ls
   
   (No Windows, use dir.)

---

3. *Instale as dependências do projeto:*
   No terminal, execute o comando abaixo para instalar todas as dependências necessárias. Este comando utiliza o gerenciador de pacotes Node.js (npm).
   
   npm install

---

4. *Configure variáveis de ambiente:*
   Verifique se há um arquivo .env.example ou similar na pasta do projeto. Caso exista, siga estas etapas:

   - Renomeie o arquivo .env.example para .env:
     
     mv .env.example .env
     
   - Abra o arquivo .env em um editor de texto e configure as variáveis conforme necessário, como a URL do backend. Exemplo:
     
     VITE_API_URL=http://localhost:8989/api 

---

5. *Inicie o servidor de desenvolvimento:*
   Após a instalação das dependências, inicie o servidor de desenvolvimento com o comando:
  
   npm run dev
   
   Caso use Yarn, o comando será:
 
   yarn dev
   

   > *Nota:* O comando exibirá no terminal a URL para acessar o frontend. Geralmente será algo como:
   
     VITE v6.0.7  ready in 4344 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ➜  Vue DevTools: Open http://localhost:5173/__devtools__/ as a separate window
  ➜  Vue DevTools: Press Alt(⌥)+Shift(⇧)+D in App to toggle the Vue DevTools
  ➜  press h + enter to show help
   

---

6. *Acesse o projeto no navegador:*
   Copie a URL exibida no terminal, como http://localhost:5173/, e cole no navegador. Isso abrirá a interface do projeto.
   (ou pressione ctrl + clique para ser direcionado a url)

---

7. *Verifique se há erros no console:*
   Caso a aplicação não carregue ou apresente erros, revise:
   - Configuração do arquivo .env.
   - Mensagens de erro no terminal.
   - Mensagens de erro no console do navegador (pressione F12 para abrir as ferramentas de desenvolvedor).

---

8. *Build para produção (opcional):*
   Se você precisar gerar uma versão otimizada para produção, execute:
  
   npm run build
   
   Isso criará os arquivos finais na pasta dist.

---


# README - Backend Laravel com Docker Compose

## Descrição

Este é o backend de uma aplicação Laravel, configurado para rodar em contêineres Docker com suporte a banco de dados MySQL. O Docker Compose é usado para orquestrar os contêineres.

---

## Requisitos

- Docker
- Docker Compose
- Composer

---

### 1. Acesse a pasta do backend

Abra o terminal ou prompt de comando e navegue até a pasta do backend:

bash
cd backend


---

### 2. aplique o comando para construir os Contêineres e suba os Contêineres Docker em segundo plano 

Construa os contêineres com o comando:

bash
docker-compose --build

Suba os contêineres com o comando:
bash
docker-compose up -d


---

### 3. Entre dentro do Contêiner para executar os comando subsequentes 

Use o comando:

bash
docker-compose exec app bash

---


### 4. Instale o Composer (se necessário)

O Laravel utiliza o Composer para gerenciar dependências. Certifique-se de que o Composer esteja instalado no seu sistema. Para verificar:

bash
composer --version


Caso não esteja instalado, siga as instruções no site oficial: [Composer Download](https://getcomposer.org/download/).

---

### 5. Instale as Dependências do Projeto

Execute o seguinte comando para instalar as dependências do backend, listadas no arquivo `composer.json`:

bash
composer install


---

### 6. Configure o Arquivo `.env`

Verifique se há um arquivo chamado `.env.example` no projeto. Se houver, renomeie-o para `.env`:

bash
cp .env.example .env


Abra o arquivo `.env` em um editor de texto e configure as variáveis de ambiente. Algumas configurações comuns incluem:

#### Banco de Dados

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_test
DB_USERNAME=root
DB_PASSWORD=<sua senha>


#### URL da Aplicação

env
APP_URL=http://localhost


---

### 7. Gere a Chave da Aplicação

O Laravel precisa de uma chave de criptografia para funcionar. Gere-a com o comando:

bash
php artisan key:generate


Isso criará uma chave no campo `APP_KEY` do arquivo `.env`.

---

### 8. Configure o Banco de Dados

O banco de dados será gerado automaticamente pelo ORM do Laravel ao rodar as migrações. Certifique-se de que as configurações no arquivo `.env` estejam corretas.

---

### 9. Rode as Migrações e Seeders

Caso o projeto inclua tabelas ou dados predefinidos, rode as migrações e seeders:

bash
php artisan migrate --seed


Isso criará as tabelas no banco e preencherá dados básicos (se os seeders existirem).

#### Gerar Migrações Manualmente

Se você enfrentar erros ao rodar as migrações, pode executá-las manualmente com os seguintes comandos dentro do Contêiner do backend:

1. Resetar as migrações:

   bash
   php artisan migrate:reset
   

2. Rodar novamente todas as migrações:

   bash
   php artisan migrate
   

3. Para rodar os seeders separadamente (caso não tenham sido incluídos):

   bash
   php artisan db:seed
   

---

### 10. Inicie o Servidor de Desenvolvimento

Para rodar a aplicação localmente, use o servidor embutido do PHP:

bash
php artisan serve


Por padrão, o Laravel estará disponível em `http://127.0.0.1:8000`.

---

## Acessar o Backend

Abra o navegador e acesse:


http://localhost:8989


---

## Problemas Comuns e Soluções

1. **Erro de conexão com o banco de dados**  
   Verifique se o host `DB_HOST=db` está configurado corretamente no arquivo `.env`.

2. **Permissões de arquivos**  
   Certifique-se de que as pastas `storage` e `bootstrap/cache` possuem as permissões corretas.

3. **Contêineres não iniciam**  
   Use o comando `docker-compose logs` para verificar os logs e identificar o problema.

4. **Usuário 'docker' nao teve a permissão de executar as migrations**
   Navegue ate o contêiner do banco de dados com o comando:
    bash
   docker exec -it mysql-db mysql -u root -p
   ```
   Acesse com a senha do seu mysql definida no .env em:
   DB_PASSWORD=<sua senha>

   Dentro do mysql execute as Querys
   CREATE USER 'docker'@'%' IDENTIFIED BY '<sua senha>';
   GRANT ALL PRIVILEGES ON laravel.* TO 'docker'@'%';
   FLUSH PRIVILEGES;
