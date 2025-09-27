# Conexão Saber

Plataforma de integração entre escolas e alunos, voltada para a oferta de cursos preparatórios para o ENEM. 
O sistema permite que a escola cadastre cursos e aulas, e que os alunos acessem os conteúdos online.

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
├── tests/
│   └── api_test.php         # Testes básicos dos endpoints
└── ConexaoSaber.postman_collection.json
```

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

## Como rodar no Laragon

1. Copie a pasta `conexaosaber_repo` para `C:\laragon\www`.  
2. Inicie o Laragon.  
3. Acesse no navegador:  
   - **Escola:** `http://localhost/conexaosaber_repo/school_api.html`  
   - **Aluno:** `http://localhost/conexaosaber_repo/index_api.html`  
   - **API:** `http://localhost/conexaosaber_repo/api.php`  

## Testes
- Execute `php tests/api_test.php` para rodar os testes básicos dos endpoints.  

## ODS 11
Esse projeto está alinhado ao ODS 11 - Cidades e Comunidades Sustentáveis, ajudando a ampliar o acesso a cursos preparatórios para o ENEM. Assim, promove mais inclusão social e igualdade de oportunidades no campo da educação.
