# Documentação da API Conexão Saber

A API utiliza PHP e armazena os dados em `data/integradeu_data.json`.  
Todas as requisições usam `Content-Type: application/json` e método **POST**.

## Endpoints

### Registro de Escola
- **URL:** `api.php?action=register_school`
- **Body:**
```json
{"email":"escola@teste.com","password":"1234"}
```
- **Resposta:**
```json
{"ok":true,"school":{"email":"escola@teste.com"}}
```

### Login de Escola
- **URL:** `api.php?action=login_school`
- **Body:**
```json
{"email":"escola@teste.com","password":"1234"}
```
- **Resposta:**
```json
{"ok":true,"school":{"email":"escola@teste.com"}}
```

### Registro de Aluno
- **URL:** `api.php?action=register_user`
- **Body:**
```json
{"email":"aluno@teste.com","password":"1234","school_email":"escola@teste.com"}
```
- **Resposta:**
```json
{"ok":true,"user":{"email":"aluno@teste.com"}}
```

### Login de Aluno
- **URL:** `api.php?action=login_user`
- **Body:**
```json
{"email":"aluno@teste.com","password":"1234"}
```
- **Resposta:**
```json
{"ok":true,"user":{"email":"aluno@teste.com"}}
```

### Adicionar Curso
- **URL:** `api.php?action=add_course`
- **Body:**
```json
{"title":"Matemática","teacher":"João","description":"Funções","school_email":"escola@teste.com"}
```
- **Resposta:**
```json
{"ok":true,"course":{"id":123456,"title":"Matemática"}}
```

### Remover Curso
- **URL:** `api.php?action=delete_course`
- **Body:**
```json
{"course_id":123456}
```
- **Resposta:**
```json
{"ok":true}
```

### Adicionar Aula
- **URL:** `api.php?action=add_lesson`
- **Body:**
```json
{"course_id":123456,"title":"Funções Afim","url":"https://youtu.be/video"}
```
- **Resposta:**
```json
{"ok":true}
```

### Editar Aula
- **URL:** `api.php?action=edit_lesson`
- **Body:**
```json
{"course_id":123456,"lesson_index":0,"title":"Funções Quadráticas","url":"https://youtu.be/video2"}
```
- **Resposta:**
```json
{"ok":true}
```

### Remover Aula
- **URL:** `api.php?action=delete_lesson`
- **Body:**
```json
{"course_id":123456,"lesson_index":0}
```
- **Resposta:**
```json
{"ok":true}
```

---

## 🔴 Tratamento de Erros

- **400 Bad Request** → entrada inválida.  
  ```json
  {"erro": "Dados inválidos"}
  ```

- **404 Not Found** → recurso não encontrado.  
  ```json
  {"erro": "Recurso não encontrado"}
  ```

- **500 Internal Server Error** → erro inesperado no servidor.  
  ```json
  {"erro": "Erro interno, tente novamente mais tarde"}
  ```
