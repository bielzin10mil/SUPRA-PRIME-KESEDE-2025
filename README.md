# SupraPrime Academia

## Descrição do Projeto
O projeto SupraPrime Academia é uma plataforma de e-commerce dedicada à venda de suplementos e equipamentos para fitness. A aplicação visa proporcionar uma experiência de compra fluida e intuitiva, permitindo que usuários naveguem, selecionem e adquiram produtos de forma eficiente e segura.

### Objetivos
- **Facilitar a compra** de suplementos e equipamentos de fitness.
- **Oferecer uma interface amigável** e adaptada a diferentes dispositivos.
- **Gerenciar eficientemente** o inventário e os usuários.
- **Garantir a segurança** na autenticação e nas transações.

## Funcionalidades
- **Autenticação**: Login, registro e logout de usuários.
- **Gerenciamento de Produtos**: Adicionar, editar, remover e listar produtos.
- **Gerenciamento de Usuários**: Adicionar, editar, remover e listar usuários.
- **Carrinho de Compras**: Adicionar, remover e atualizar produtos no carrinho.
- **Histórico de Compras**: Visualizar o histórico de compras dos clientes.
- **Design Responsivo**: Layout adaptado para diferentes dispositivos (desktop e mobile).

## Tecnologias Utilizadas
- **Frontend**:
  - HTML5
  - CSS3
  - JavaScript
  - Bootstrap 4 para responsividade
  - Font Awesome para ícones
- **Backend**:
  - PHP para lógica de servidor
- **Banco de Dados**:
  - MySQL
- **Ferramentas**:
  - XAMPP para ambiente de desenvolvimento local

## Estrutura do Projeto
- **index.php**: Página principal exibindo produtos em destaque.
- **view/**: Diretório contendo as páginas de visualização como produtos, sobre, cadastro e login.
- **css/**: Arquivos de estilo CSS.
- **JS/**: Scripts JavaScript para funcionalidades dinâmicas.

## Como Executar o Projeto

### Pré-requisitos
- XAMPP ou outro servidor local com suporte a PHP e MySQL.
- Navegador web atualizado.

### Passos para Executar

1. **Clone os repositórios do frontend e backend**:
    ```bash
    git clone https://github.com/lucastamashirolyt/SupraPrime.git
    git clone https://github.com/lucastamashirolyt/SupraPrime_backend.git
    ```

2. **Configure o servidor local**:
    - Coloque os arquivos do frontend na pasta `htdocs` do XAMPP:
      ```bash
      mv "C:\xampp\htdocs\SupraPrime"
      ```
    - Coloque os arquivos do backend na pasta `htdocs` do XAMPP:
      ```bash
      mv "C:\xampp\htdocs\backend"
      ```

3. **Configure o banco de dados**:
    - Crie um banco de dados MySQL chamado `auth_app`.
    - Importe o arquivo `data` para dentro de 'C:xampp/mysql' que está localizado na pasta `backend` para criar as tabelas necessárias.

4. **Configure os arquivos de conexão com o banco de dados**:
    - No backend, edite o arquivo `config.php` com as credenciais do seu banco de dados:
      ```php - Exemplo da configuração do config.php com banco de dados abaixo:
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "auth_app";

      // Cria a conexão
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Verifica a conexão
      if ($conn->connect_error) {
          die("Conexão falhou: " . $conn->connect_error);
      }
      ?>
      ```

5. **Inicie o servidor Apache e MySQL pelo painel de controle do XAMPP**.

6. **Acesse o projeto**:
    - Abra o navegador e acesse `http://localhost/supra-prime-academia-frontend`.

### Passos para Executar Ngrok (Opcional)
1. **Iniciar o Ngrok**:
    - No terminal, navegue até a pasta onde você extraiu o ngrok.
    - Execute o comando para expor o servidor local na porta correta. Se o Apache estiver rodando na porta 80, use:
      ```sh
      ngrok http 80
      ```

2. **Obtenha o URL público**:
    - O ngrok fornecerá um URL público (algo como `http://abcd1234.ngrok.io`). Este URL será usado para acessar o seu servidor local pela internet.

3. **Testar a Conexão**:
    - Acesse o URL público fornecido pelo ngrok no seu navegador e verifique se o seu projeto está funcionando corretamente.
    - Certifique-se de que todas as funcionalidades (login, registro, carrinho de compras, etc.) estão funcionando como esperado.

## Agradecimentos
Agradecemos a todos que contribuíram direta ou indiretamente para o desenvolvimento deste projeto:
- Inspiração: Projetos de e-commerce que serviram de base.
- Suporte: Equipe de mentores, video aulas online e colegas que ofereceram feedback valioso.

# SupraPrime Academia

## Descrição do Projeto
O projeto SupraPrime Academia é uma plataforma de e-commerce dedicada à venda de suplementos e equipamentos para fitness. A aplicação visa proporcionar uma experiência de compra fluida e intuitiva, permitindo que usuários naveguem, selecionem e adquiram produtos de forma eficiente e segura.

### Objetivos
- **Facilitar a compra** de suplementos e equipamentos de fitness.
- **Oferecer uma interface amigável** e adaptada a diferentes dispositivos.
- **Gerenciar eficientemente** o inventário e os usuários.
- **Garantir a segurança** na autenticação e nas transações.

## Funcionalidades
- **Autenticação**: Login, registro e logout de usuários.
- **Gerenciamento de Produtos**: Adicionar, editar, remover e listar produtos.
- **Gerenciamento de Usuários**: Adicionar, editar, remover e listar usuários.
- **Carrinho de Compras**: Adicionar, remover e atualizar produtos no carrinho.
- **Histórico de Compras**: Visualizar o histórico de compras dos clientes.
- **Design Responsivo**: Layout adaptado para diferentes dispositivos (desktop e mobile).

## Tecnologias Utilizadas
- **Frontend**:
  - HTML5
  - CSS3
  - JavaScript
  - Bootstrap 4 para responsividade
  - Font Awesome para ícones
- **Backend**:
  - PHP para lógica de servidor
- **Banco de Dados**:
  - MySQL
- **Ferramentas**:
  - XAMPP para ambiente de desenvolvimento local

## Estrutura do Projeto
- **index.php**: Página principal exibindo produtos em destaque.
- **view/**: Diretório contendo as páginas de visualização como produtos, sobre, cadastro e login.
- **backend/**: Diretório com a lógica de backend, incluindo APIs e configuração do banco de dados.
- **css/**: Arquivos de estilo CSS.
- **JS/**: Scripts JavaScript para funcionalidades dinâmicas.

## Como Executar o Projeto

### Pré-requisitos
- XAMPP ou outro servidor local com suporte a PHP e MySQL.
- Navegador web atualizado.

### Passos para Executar
1. **Clone o repositório**:
    ```bash
    git clone https://github.com/seu-usuario/supra-prime-academia.git
    ```
2. **Configure o banco de dados**:
    - Crie um banco de dados MySQL chamado `auth_app`.
    - Importe o arquivo `auth_app.sql` localizado na pasta `backend/database` para criar as tabelas necessárias.
3. **Configure o servidor local**:
    - Coloque os arquivos do projeto na pasta `htdocs` do XAMPP.
    - Inicie o servidor Apache e MySQL pelo painel de controle do XAMPP.
4. **Acesse o projeto**:
    - Abra o navegador e acesse `http://localhost/supra-prime-academia`.

### Passos para Executar Ngrok
1. **Iniciar o Ngrok**:
    -No terminal, navegue até a pasta onde você extraiu o ngrok.
    -Execute o comando para expor o servidor local na porta correta. Se o Apache estiver rodando na porta 80, use: ngrok http 80
2. **Configure o banco de dados**:
    -O ngrok fornecerá um URL público (algo como http://abcd1234.ngrok.io). Este URL será usado para acessar o seu servidor local pela internet.
3. **Testar a Conexão**:
    -Acesse o URL público fornecido pelo ngrok no seu navegador e verifique se o seu projeto está funcionando corretamente.
    -Certifique-se de que todas as funcionalidades (login, registro, carrinho de compras, etc.) estão funcionando como esperado.


## Agradecimentos
Agradecemos a todos que contribuíram direta ou indiretamente para o desenvolvimento deste projeto:
- **Inspiração**: Projetos de e-commerce que serviram de base.
- **Suporte**: Equipe de mentores e colegas que ofereceram feedback valioso.

## Contato
Para quaisquer dúvidas ou sugestões, entre em contato conosco:
- **Lucas Yuji**: lucastamashirolyt@gmail.com
- **Gustavo Pascoal**: gustavopascoal@gmail.com
- **Gabriel Silveira**: gabrielsilveira@gmail.com

## Licença
Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contribuição

### Como Contribuir
1. **Fork este repositório**.
2. **Crie uma branch** para sua feature (`git checkout -b feature/NovaFeature`).
3. **Commit suas mudanças** (`git commit -m 'Adiciona nova feature'`).
4. **Push para a branch** (`git push origin feature/NovaFeature`).
5. **Abra um Pull Request**.

### Regras de Contribuição
- Mantenha o código limpo e bem documentado.
- Siga as convenções de nomenclatura e estrutura existentes.
- Teste suas mudanças antes de enviar.

<h1 align="center">  Autores </h1>

| [<img loading="lazy" src="https://avatars.githubusercontent.com/u/114181346?v=4" width=115><br><sub>Lucas Yuji</sub>](https://github.com/lucastamashirolyt) |  [<img loading="lazy" src="https://avatars.githubusercontent.com/u/142549426?v=4" width=115><br><sub>Gabriel Silveira</sub>](https://github.com/bielzin10mil) |  [<img loading="lazy" src="https://avatars.githubusercontent.com/u/142549465?v=4" width=115><br><sub>Gustavo Pascoal</sub>](https://github.com/gupascoal) |
| :---: | :---: | :---: |
