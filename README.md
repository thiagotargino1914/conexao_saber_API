# Conexão Saber API

## Objetivo do Trabalho  
O objetivo é criar uma API REST que integre dois sistemas distintos:  
- **Sistema da Escola**: responsável por cadastrar cursos e aulas.  
- **Sistema do Aluno**: responsável por acessar os conteúdos cadastrados.  

Assim, a API atua como ponte entre escola e aluno, promovendo acesso à cursos e aulas preparatórias para o Enem.

---

## Estrutura do Projeto
```
conexaosaber_repo/
├── api.php                  # API PHP para integração
├── index_api.html           # Interface do aluno (online)
├── school_api.html          # Interface da escola (online)
├── data/
│   └── integraedu_data.json # Base de dados em JSON
├── docs/
│   └── API.md               # Documentação detalhada dos endpoints
├── teste/
│   └── api_test.php         # Testes básicos dos endpoints
└── ConexaoSaber.postman_collection.json
```

## Descrição Funcional
A plataforma permite que:
- Escolas cadastrem cursos e aulas.  
- Alunos consultem e se inscrevam em cursos.  
- A comunicação ocorra via **API REST/HTTP com JSON**.

---

## Arquitetura da API
A API segue o modelo cliente-servidor.  
O fluxo principal é:

**Escola (Cadastro de Cursos/Aulas) ⇄ API REST ⇄ Aluno (Consumo de Conteúdo)**

## Endpoints Principais

### Registro de Escola
- **POST** `/api.php?action=register_school`
- Body:
```json
{"email":"escola@teste.com","password":"1234"}
```

### Login de Escola
- **POST** `/api.php?action=login_school`
- Body:
```json
{"email":"escola@teste.com","password":"1234"}
```

### Registro de Aluno
- **POST** `/api.php?action=register_user`
- Body:
```json
{"email":"aluno@teste.com","password":"1234","school_email":"escola@teste.com"}
```

### Login de Aluno
- **POST** `/api.php?action=login_user`
- Body:
```json
{"email":"aluno@teste.com","password":"1234"}
```

Veja `docs/API.md` para a lista completa.

## Instruções de Execução

## Como rodar no Laragon

1. Copie a pasta `conexaosaber_repo` para `C:\laragon\www`.  
2. Inicie o Laragon.  
3. Acesse no navegador:  
   - **Escola:** `http://localhost/conexaosaber_repo/school_api.html`  
   - **Aluno:** `http://localhost/conexaosaber_repo/index_api.html`  
   - **API:** `http://localhost/conexaosaber_repo/api.php`  
4. Importar a coleção do Postman (`ConexaoSaber.postman_collection.json`).

## Testes
- Execute `teste/api_test.php` para rodar os testes básicos dos endpoints.  

## Relação com ODS 11
O projeto **Conexão Saber** contribui com o **ODS 11 - Cidades e Comunidades Sustentáveis**,  
pois amplia o acesso à educação, reduz desigualdades sociais e promove inclusão digital. 

---

## Equipe
- Cleberson Assunção Tavares – 2325404  
- Rodrigo de Queiroz Oliveira Rodrigues - 2326198  
- Mayara Pinto da Silva – 2317573  
- Francisco Flavio Rodrigues de Menezes – 2314219  
- Nicolas Lima Ribeiro - 2326327  
- Thiago Targino de Souza – 2326340  

**Papel dos integrantes:**  
- Desenvolvimento: Thiago, Nicolas  
- Testes: Rodrigo, Mayara  
- Documentação: Cleberson, Francisco  
