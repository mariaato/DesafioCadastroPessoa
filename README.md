# Sistema de Cadastro de Pessoas Físicas 🧑🏽

Este projeto foi desenvolvido como parte de um desafio para a vaga de Estágio em Suporte e Desenvolvimento de Sistemas. A proposta era criar um sistema de cadastro de pessoas físicas com operações de CRUD (Criar, Ler, Atualizar e Deletar), salvando os dados em um banco de dados em memória (session PHP), além de implementar validações para evitar cadastros duplicados.

## Funcionalidades 🛠️

- **Cadastro de Pessoas:** Formulário completo para inserir dados de identificação e contato de uma pessoa.
- **Validação de CPF:** Evita a duplicação de cadastros ao verificar se o CPF já foi registrado, realiza o cálculo de validação do CPF e verifica se o CPF está em um formato correto.
- **Preenchimento automático de endereço:** Utiliza a API ViaCEP para preencher os dados de endereço ao inserir o CEP.
- **Sessões em PHP:** Dados são armazenados em sessões, simulando um banco de dados em memória, conforme solicitado.
- **CRUD Completo:** O sistema permite criar, ler, atualizar e deletar registros de pessoas.
- **Interface com HTML e CSS:** A interface foi construída para simplificar a navegação e organização das informações.
  
## Estrutura do Projeto 🏗️

O sistema foi construído utilizando PHP para o backend, HTML e CSS para o frontend, com as seguintes seções principais:

1. **Painel de Cadastro**: formulário para inserção de dados com preenchimento automático de endereço.
2. **Tabela de Registros**: exibe uma lista de pessoas cadastradas.
3. **Formulário de Edição e Exclusão**: para editar e deletar registros diretamente na lista.

## Desafios e Soluções 💥

1. **Validação de CPF Duplicado e Cálculo de Validade**:
   - *Desafio*: Evitar a duplicação de cadastros com o mesmo CPF e garantir que o CPF seja válido.
   - *Solução*: Implementada uma validação no backend que verifica se o CPF já está presente e realiza o cálculo para garantir sua validade antes de permitir um novo cadastro.

2. **Preenchimento Automático de Endereço via API ViaCEP**:
   - *Desafio*: Integrar o sistema com uma API externa para automatizar o preenchimento de endereço.
   - *Solução*: Utilizei a API ViaCEP para que o sistema preencha os campos de endereço automaticamente ao inserir um CEP válido, melhorando a experiência do usuário.

3. **Manipulação de Sessões para Armazenamento Temporário de Dados**:
   - *Desafio*: Utilizar sessões PHP para simular um banco de dados, mantendo os dados temporários durante a execução.
   - *Solução*: Utilizei `$_SESSION` para armazenar registros, simulando um banco de dados em memória, conforme o desafio.

4. **Interface Responsiva e Amigável**:
   - *Desafio*: Organizar o layout dos dados de forma limpa e acessível.
   - *Solução*: Desenvolvi uma interface simplificada com HTML e CSS, incluindo a funcionalidade de alternar entre visualização e edição.

## Tecnologias Utilizadas 🌐

- **PHP**: Backend e manipulação de dados.
- **HTML/CSS**: Estrutura e estilo do frontend.
- **API ViaCEP**: Preenchimento automático dos campos de endereço a partir do CEP.

## Próximos Passos 👣

- **Persistência de Dados**: Implementar um banco de dados real (por exemplo, SQLite ou MySQL) para persistir os dados.
- **Testes Unitários**: Acrescentar testes unitários para verificar a integridade das operações CRUD e da validação de CPF.
- **Validações Adicionais**: Melhorar as validações de campos, como CPF e email, para garantir dados mais confiáveis.

## Diagrama de Classes 

```mermaid
classDiagram
  class Pessoa {
    Integer id
    +String nome
    +String cpf
    +Date dataNascimento
    +String genero
    +String estadoCivil
    +String cep
    +String rua
    +String bairro
    +String cidade
    +String estado
    +String telefone
    +String email
    +DateTime dataCadastro
  }
