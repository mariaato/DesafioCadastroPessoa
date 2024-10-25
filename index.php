<?php
session_start();

if (isset($_POST['finalizar_sessao'])) {
    session_unset(); 
    session_destroy(); 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}

if (!isset($_SESSION['pessoas'])) {
    $_SESSION['pessoas'] = [];
}

function listPessoas() {
    return $_SESSION['pessoas'];
}

function addPessoa($nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cidade, $estado, $telefone, $email) {
    foreach ($_SESSION['pessoas'] as $pessoa) {
        if ($pessoa['cpf'] === $cpf) {
            return "Erro: CPF já cadastrado!";
        }
    }
    $_SESSION['pessoas'][] = ['id' => uniqid(), 'nome' => $nome, 'cpf' => $cpf, 'dataNascimento' => $dataNascimento, 'genero' => $genero, 'estadoCivil' => $estadoCivil, 'cidade' => $cidade, 'estado' => $estado, 'telefone' => $telefone, 'email' => $email];
    return "Pessoa cadastrada com sucesso!";
}

function editPessoa($id, $nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cidade, $estado, $telefone, $email) {
    foreach ($_SESSION['pessoas'] as &$pessoa) {
        if ($pessoa['id'] === $id) {
            $pessoa['nome'] = $nome;
            $pessoa['cpf'] = $cpf;
            $pessoa['dataNascimento' ] = $dataNascimento;
            $pessoa['genero'] = $genero;
            $pessoa['estadoCivil'] = $estadoCivil;
            $pessoa['cidade'] = $cidade;
            $pessoa['estado'] = $estado;
            $pessoa['telefone'] = $telefone;
            $pessoa['email'] = $email;

            return "Pessoa atualizada com sucesso!";
        }
    }
    return "Pessoa não encontrada.";
}

function deletePessoa($id) {
    foreach ($_SESSION['pessoas'] as $key => $pessoa) {
        if ($pessoa['id'] === $id) {
            unset($_SESSION['pessoas'][$key]);
            return "Pessoa deletada com sucesso!";
        }
    }
    return "Pessoa não encontrada.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoas</title>
    <style>
        header{
            text-align:center;
            justify-content: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
<header>
    <h1>Cadastro de Pessoas</h1>
    <form method="POST" style="margin-top: 50px;">
        <button type="submit" name="finalizar_sessao">Finalizar Sessão</button>
    </form>
</header>


    <form method="POST">
        <label for="Nome">Nome completo</label>
        <input type="text" name="nome" class="form-control" placeholder="Digite seu nome completo" required>

        <label for="dataNascimento">Data de Nascimento</label>
        <input type="date" name="dataNascimento" class="form-control" placeholder="Digite sua data de nascimento" required>

        <label for="genero">Gênero</label>
        <select name="genero" class="form-control" required>
            <option value="">Selecione seu gênero</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select>

        <label for="cpf">CPF</label>
        <input type="text" name="cpf" class="form-control" placeholder="Digite CPF" required>

        <label for="cpf">Estado Civil</label>
        <select name="estadoCivil" class="form-control">
            <option value="">Selecione seu estado civil</option>
            <option value="Solteiro">Solteiro</option>
            <option value="Casado">Casado</option>
            <option value="Divorciado">Divorciado</option>
            <option value="Viúvo">Viúvo</option>
            <option value="Outro">Outro</option>
        </select>

        <label for="cidade">Cidade</label>
        <input type="text" name="cidade" class="form-control" placeholder="Digite sua cidade" required>

        <label for="estado">Estado</label>
        <select name="estado" class="form-control" required>
            <option value="">Selecione um estado</option>
            <option value="SC">Santa Catarina</option>
            <option value="PR">Parana</option>
            <option value="SP">Sao Paulo</option>
            <option value="RJ">Rio de Janeiro</option>
        </select>

        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" class="form-control" placeholder="Digite seu telefone" required>
        
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control" placeholder="Digite seu email" required>

        <button type="submit" name="action" value="cadastrar">Cadastrar</button>
    </form>

   

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? null;
        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $dataNascimento = $_POST['dataNascimento'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $estadoCivil = $_POST['estadoCivil'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $email = $_POST['email'] ?? '';

        if ($action === 'cadastrar') {
            echo addPessoa($nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cidade, $estado, $telefone, $email);
        } elseif ($action === 'atualizar') {
            echo editPessoa($id, $nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cidade, $estado, $telefone, $email);
        } elseif ($action === 'deletar') {
            echo deletePessoa($id);
        }
    }

    $pessoas = listPessoas();
    if (count($pessoas) > 0): ?>
        <table border="1">
            <tr>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th>Data Nascimento</th>
                <th>Gênero</th>
                <th>Estado Civil</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Telefone</th>
                <th>Email</th>

                <th>Ações</th>
            </tr>
            <?php foreach ($pessoas as $pessoa): ?>
            <tr>
                <td><?php echo htmlspecialchars($pessoa['nome']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['cpf']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['dataNascimento']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['genero']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['estadoCivil']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['cidade']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['estado']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['telefone']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['email']); ?></td>
                    
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $pessoa['id']; ?>">
                        <input type="text" name="nome" value="<?php echo htmlspecialchars($pessoa['nome']); ?>">
                        <input type="text" name="cpf" value="<?php echo htmlspecialchars($pessoa['cpf']); ?>">
                        <button type="submit" name="action" value="atualizar">Editar</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $pessoa['id']; ?>">
                        <button type="submit" name="action" value="deletar">Deletar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h1> Editar </h1>
        <table>
            <tr>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th>Data Nascimento</th>
                <th>Gênero</th>
                <th>Estado Civil</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Telefone</th>
                <th>Email</th>
            </tr>
            <?php foreach ($pessoas as $pessoa): ?>
            <tr>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $pessoa['id']; ?>">
                    <td><input type="text" name="nome" value="<?php echo htmlspecialchars($pessoa['nome']); ?>"></td>
                    <td><input type="text" name="cpf" value="<?php echo htmlspecialchars($pessoa['cpf']); ?>"></td>
                    <td><input type="date" name="dataNascimento" value="<?php echo htmlspecialchars($pessoa['dataNascimento']); ?>"></td>
                    <td><input type="text" name="genero" value="<?php echo htmlspecialchars($pessoa['genero']); ?>"></td>
                    <td><input type="text" name="estadoCivil" value="<?php echo htmlspecialchars($pessoa['estadoCivil']); ?>"></td>
                    <td><input type="text" name="cidade" value="<?php echo htmlspecialchars($pessoa['cidade']); ?>"></td>
                    <td><input type="text" name="estado" value="<?php echo htmlspecialchars($pessoa['estado']); ?>"></td>
                    <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($pessoa['telefone']); ?>"></td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($pessoa['email']); ?>"></td>


                    <td><button type="submit" name="action" value="atualizar">Salvar</button></td>
                    <td><button type="submit" name="action" value="deletar">Deletar</button></td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>Nenhuma pessoa cadastrada.</p>
    <?php endif; ?>
</body>
</html>
