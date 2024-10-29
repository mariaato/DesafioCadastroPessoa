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
    <link rel="stylesheet" href="estilo.css"> 

</head>
<body>
<header>
    <h1>Cadastro de Pessoas</h1>
    <form method="POST" style="display: inline;">
        <button type="submit" name="finalizar_sessao" class="logout-button">Sair</button>
    </form>
</header>

<div class="container">
    <h2>Painel de Cadastro</h2>
    <form method="POST" class="form-container">
        
        <div class="form-group">
            <label for="Nome">Nome completo</label>
            <input type="text" name="nome" placeholder="Digite seu nome completo" required>
        </div>

        <div class="form-group">
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" name="dataNascimento" required>
        </div>

        <div class="form-group">
            <label for="genero">Gênero</label>
            <select name="genero" required>
                <option value="">Selecione seu gênero</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" placeholder="Digite CPF" required>
        </div>

        <div class="form-group">
            <label for="estadoCivil">Estado Civil</label>
            <select name="estadoCivil" required>
                <option value="">Selecione seu estado civil</option>
                <option value="Solteiro">Solteiro</option>
                <option value="Casado">Casado</option>
                <option value="Divorciado">Divorciado</option>
                <option value="Viúvo">Viúvo</option>
                <option value="Outro">Outro</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" placeholder="Digite sua cidade" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" required>
                <option value="">Selecione um estado</option>
                <option value="SC">Santa Catarina</option>
                <option value="PR">Parana</option>
                <option value="SP">São Paulo</option>
                <option value="RJ">Rio de Janeiro</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" placeholder="Digite seu telefone" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Digite seu email" required>
        </div>

        <div class="submit-button">
            <button type="submit" name="action" value="cadastrar">Cadastrar</button>
        </div>
    </form>
</div>

   

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
                    
               
            </tr>
            <?php endforeach; ?>
        </table>

        <h1> Editar </h1>
        <table>
        <tr>
            <th>Nome Completo</th>
            <th>CPF</th>
        </tr>
        <?php foreach ($pessoas as $pessoa): ?>
        <tr onclick="toggleDetails(this)">
            <td><?php echo htmlspecialchars($pessoa['nome']); ?></td>
            <td><?php echo htmlspecialchars($pessoa['cpf']); ?></td>
        </tr>
        <tr class="details-row" style="display: none;">
            <td colspan="2">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $pessoa['id']; ?>">
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($pessoa['nome']); ?>" required>
                    <input type="text" name="cpf" value="<?php echo htmlspecialchars($pessoa['cpf']); ?>" required>
                    <input type="date" name="dataNascimento" value="<?php echo htmlspecialchars($pessoa['dataNascimento']); ?>" required>
                    <input type="text" name="genero" value="<?php echo htmlspecialchars($pessoa['genero']); ?>" required>
                    <input type="text" name="estadoCivil" value="<?php echo htmlspecialchars($pessoa['estadoCivil']); ?>" required>
                    <input type="text" name="cidade" value="<?php echo htmlspecialchars($pessoa['cidade']); ?>" required>
                    <input type="text" name="estado" value="<?php echo htmlspecialchars($pessoa['estado']); ?>" required>
                    <input type="text" name="telefone" value="<?php echo htmlspecialchars($pessoa['telefone']); ?>" required>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($pessoa['email']); ?>" required>
                    <button type="submit" name="action" value="atualizar" class="save-button">Salvar</button>
                    <button type="submit" name="action" value="deletar" class="delete-button">Deletar</button>
                </form>
            </td>
        </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>Nenhuma pessoa cadastrada.</p>
    <?php endif; ?>
<br>
<br>

    <script>
    function toggleDetails(row) {
        let detailsRow = row.nextElementSibling;
        detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
        row.classList.toggle("expanded");
    }
</script>
</body>
</html>
