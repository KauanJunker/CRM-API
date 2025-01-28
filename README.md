# CRM API

Esta aplicação é uma API de CRM desenvolvida com Laravel, destinada a gerenciar leads, contatos e tarefas. Ela inclui autenticação, notificações e relatórios automatizados.

---

## Tecnologias Utilizadas

- **PHP** (v8.2)
- **Laravel Framework** (v11.31)
- **Laravel Sanctum** para autenticação
- **Twilio SDK** para notificações via WhatsApp

## Requisitos

- PHP 8.2+
- Composer
- Banco de Dados (MySQL ou SQLite para testes)

---

## Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o arquivo `.env` com as informações do banco de dados e da API do Twilio.

4. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

5. Execute as migrations:
   ```bash
   php artisan migrate
   ```

6. Para testes, configure o SQLite no arquivo `.env` e execute as migrations para o ambiente de teste:
   ```bash
   php artisan migrate --env=testing
   ```

---

## Funcionalidades

### Gerenciamento de Contatos
- Listar contatos.
- Criar, atualizar e excluir contatos.

### Gerenciamento de Leads
- Listar leads com filtros por status ou data.
- Criar, atualizar e excluir leads.

### Gerenciamento de Tarefas
- Listar tarefas associadas a contatos ou leads.
- Criar, atualizar (marcar como concluída) e excluir tarefas.

### Notificações
- Envio de lembretes automáticos para tarefas próximas do vencimento.
- Notificações de novos leads ou alterações importantes.
- Envio de mensagens via WhatsApp para leads.

### Automação com Eventos e Listeners
- Atualização de relatórios e status com base em eventos como:
  - **LeadCreated**: Automatizar tarefas ou enviar notificações.
  - **TaskDue**: Notificar sobre tarefas pendentes.
  - **LeadStatusChanged**: Atualizar relatórios automaticamente.

### Autorização e Permissões
- Controle de permissões para diferentes tipos de usuários (admin, equipe de vendas).
- Policies configuradas para operações em leads, contatos e tarefas.

### Relatórios
- Geração de relatórios sobre:
  - Quantidade de leads por status.
  - Tarefas pendentes e concluídas.
  - Contatos e leads mais ativos.

### Testes
- Testes unitários para controllers e models.

---

## Observações

- Esta aplicação utiliza filas (queues) para processamento de jobs. Certifique-se de iniciar o worker:
  ```bash
  php artisan queue:work
  ```
- Para o envio de mensagens via WhatsApp, configure corretamente as credenciais da API Twilio no arquivo `.env`.

---

## Licença

Este projeto é open-source e está licenciado sob os termos da [MIT License](LICENSE).

