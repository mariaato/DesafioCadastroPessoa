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

function addPessoa($nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cep, $rua, $bairro, $cidade, $estado, $telefone, $email) {
    foreach ($_SESSION['pessoas'] as $pessoa) {
        if ($pessoa['cpf'] === $cpf) {
            return "Erro: CPF já cadastrado!";
        }
    }

    date_default_timezone_set('America/Sao_Paulo'); 
    $dataCadastro = date("d/m/Y H:i:s"); 
    
    $_SESSION['pessoas'][] = [
        'id' => uniqid(), 
        'nome' => $nome, 
        'cpf' => $cpf, 
        'dataNascimento' => $dataNascimento,
        'genero' => $genero, 
        'estadoCivil' => $estadoCivil, 
        'cep' => $cep, 
        'rua' => $rua, 
        'bairro' => $bairro, 
        'cidade' => $cidade, 
        'estado' => $estado, 
        'telefone' => $telefone, 
        'email' => $email,
        'dataCadastro' => $dataCadastro
    ];

    return "Pessoa cadastrada com sucesso!";
}

function editPessoa($id, $nome, $cpf, $dataNascimento, $genero, $estadoCivil,$cep, $rua, $bairro, $cidade, $estado, $telefone, $email) {
    foreach ($_SESSION['pessoas'] as &$pessoa) {
        if ($pessoa['id'] === $id) {
            $pessoa['nome'] = $nome;
            $pessoa['cpf'] = $cpf;
            $pessoa['dataNascimento' ] = $dataNascimento;
            $pessoa['genero'] = $genero;
            $pessoa['estadoCivil'] = $estadoCivil;
            $pessoa['cep'] = $cep;
            $pessoa['rua'] = $rua;
            $pessoa['bairro'] = $bairro;
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

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoas</title>
    <link rel="stylesheet" href="style.css"> 

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
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required onblur="fetchAddressData()">
        </div>

        <div class="form-group">
            <label for="rua">Logradouro</label>
            <input type="text" id="rua" name="rua" placeholder="Rua/Avenida" required>
        </div>

        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro" required>
        </div>

        <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado" placeholder="Estado" required>
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
        $cep = $_POST['cep'] ?? '';
        $rua = $_POST['rua'] ?? '';
        $bairro = $_POST['bairro'] ?? '';
        $cidade = $_POST['cidade'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $email = $_POST['email'] ?? '';

        if ($action === 'cadastrar') {
            if (!validarCPF($cpf)) {
                echo "Erro: CPF inválido!";
            } else {
                echo addPessoa($nome, $cpf, $dataNascimento, $genero, $estadoCivil, $cep, $rua, $bairro, $cidade, $estado, $telefone, $email);
            }
        } elseif ($action === 'atualizar') {
            echo editPessoa($id, $nome, $cpf, $dataNascimento, $genero, $estadoCivil,$cep, $rua, $bairro, $cidade, $estado, $telefone, $email);
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
                <th>CEP</th>
                <th>Rua</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Data de Cadastro</th>

            </tr>
            <?php foreach ($pessoas as $pessoa): ?>
            <tr>
                <td><?php echo htmlspecialchars($pessoa['nome']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['cpf']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['dataNascimento']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['genero']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['estadoCivil']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['cep']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['rua']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['bairro']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['cidade']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['estado']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['telefone']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['email']); ?></td>
                <td><?php echo htmlspecialchars($pessoa['dataCadastro']); ?></td>
                    
               
            </tr>
            <?php endforeach; ?>
        </table>

        <h2> Editar </h2>
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
        <form method="POST" class="edit-form">
            <input type="hidden" name="id" value="<?php echo $pessoa['id']; ?>">
            
            <div class="form-group">
                <label>Nome Completo:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($pessoa['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label>CPF:</label>
                <input type="text" name="cpf" value="<?php echo htmlspecialchars($pessoa['cpf']); ?>" required>
            </div>

            <div class="form-group">
                <label>Data de Nascimento:</label>
                <input type="date" name="dataNascimento" value="<?php echo htmlspecialchars($pessoa['dataNascimento']); ?>" required>
            </div>

            <div class="form-group">
                <label>Gênero:</label>
                <input type="text" name="genero" value="<?php echo htmlspecialchars($pessoa['genero']); ?>" required>
            </div>

            <div class="form-group">
                <label>Estado Civil:</label>
                <input type="text" name="estadoCivil" value="<?php echo htmlspecialchars($pessoa['estadoCivil']); ?>" required>
            </div>

            <div class="form-group">
                <label>CEP:</label>
                <input type="text" name="cep" value="<?php echo htmlspecialchars($pessoa['cep']); ?>" required>
            </div>

            <div class="form-group">
                <label>Logradouro:</label>
                <input type="text" name="rua" value="<?php echo htmlspecialchars($pessoa['rua']); ?>" required>
            </div>

            <div class="form-group">
                <label>Bairro:</label>
                <input type="text" name="bairro" value="<?php echo htmlspecialchars($pessoa['bairro']); ?>" required>
            </div>

            <div class="form-group">
                <label>Cidade:</label>
                <input type="text" name="cidade" value="<?php echo htmlspecialchars($pessoa['cidade']); ?>" required>
            </div>

            <div class="form-group">
                <label>Estado:</label>
                <input type="text" name="estado" value="<?php echo htmlspecialchars($pessoa['estado']); ?>" required>
            </div>

            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="telefone" value="<?php echo htmlspecialchars($pessoa['telefone']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($pessoa['email']); ?>" required>
            </div>

            <div class="button-group">
                <button type="submit" name="action" value="atualizar" class="save-button">Salvar</button>
                <button type="submit" name="action" value="deletar" class="delete-button">Deletar</button>
            </div>
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
function fetchAddressData() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (cep.length === 8) { 
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(error => console.error('Erro ao buscar o endereço:', error));
    } else {
        alert("CEP inválido.");
    }
}
</script>
    <script>
    function toggleDetails(row) {
        let detailsRow = row.nextElementSibling;
        detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
        row.classList.toggle("expanded");
    }
</script>
</body>
<footer>
    <p>&copy; 2024 Maria Antônia | Desafio Cadastro de Pessoas |</p>

    <div class="social">
        <a href="https://www.linkedin.com/in/maria-ant%C3%B4nia-dos-santos">Linkedin |</a>
        <a href="https://github.com/mariaato">Github</a>
    </div>
    <p>  | Contato: mariaaatonha@gmail.com | Telefone: (48) 99857-6783</p>
</footer>

</html>
