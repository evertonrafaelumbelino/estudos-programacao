<?php

// Definindo o cabeçalho JSON
header('Content-Type: application/json');

// Obtendo o método da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Caminho do arquivo JSON que irá armazenar os usuários
define('ARQUIVO_JSON', 'usuarios.json');

// Função para carregar todos os usuários
function carregarUsuarios() {
    if (!file_exists(ARQUIVO_JSON)) {
        return []; // Retorna um array vazio se o arquivo não existir
    }

    $conteudo = file_get_contents(ARQUIVO_JSON);
    return json_decode($conteudo, true) ?? [];
}

// Função para salvar os usuários no arquivo JSON
function salvarUsuarios($usuarios) {
    file_put_contents(ARQUIVO_JSON, json_encode($usuarios, JSON_PRETTY_PRINT));
}

// Carrega os usuários do arquivo
$usuarios = carregarUsuarios();

// Verificando se o método é GET e se a URL requisitada é "/crud.php/usuarios"
$uri = $_SERVER['REQUEST_URI'];

// Pega o valor da coluna id
$userId = array_column($usuarios, 'id');

// Pega o valor da coluna nome
$userNome = array_column($usuarios, 'nome');

// Busca um usuário com ID específico
if ($method == 'GET' && strpos($uri, '/crud.php/usuarios?id=') === 0) {
    // Verifica se o ID foi enviado na URL
    if (!isset($_GET['id'])) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Erro ao capturar o ID enviado"]);
        exit();
    }

    // Guardar o ID enviado na URL
    $id = $_GET['id'];

    // Carrega os usuários do arquivo
    $usuarios = carregarUsuarios();

    // Pega o indice(posição) da coluna ID
    $indice = array_search($id, $userId);

    // Verifica se o indice é falso
    if ($indice === false) {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Usuário não encontrado"]);
        exit();
    }

    // Verifica se o ID existe nos usuários
    if ($userId[$indice] == $id) {
        // Imprime o usuário com o ID enviado
        echo json_encode($usuarios[$indice]);
        exit();
    } else {
        // Código de erro
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Usuário não encontrado"]);
        exit();
    }
}

// Método GET que mostra um usuário pelo nome
if ($method == 'GET' && strpos($uri, '/crud.php/usuarios?nome=') === 0) {
    // Verifica se o parâmetro 'nome' não foi enviado
    if (!isset($_GET['nome'])) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Erro ao capturar o 'nome' enviado."]);
        exit();
    }

    // Pega o parâmetro 'nome' e adiciona a variável $nome 
    $nome = $_GET['nome'];

    // Variável que contém o indice(posição) do 'nome'
    $indice = array_search($nome, $userNome);

    // Verifica se o indice é falso
    if ($indice === false) {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Usuário não encontrado"]);
        exit();
    }

    // Verifica se o parâmetro nome é igual ao nome no JSON
    if ($nome == $userNome[$indice]) {
        echo json_encode($usuarios[$indice]);
        exit();
    }

    // Respota de erro
    http_response_code(404); // Not Found
    echo json_encode(["error" => "Nenhum usuário encontrado"]);
    exit();
}

// Método POST que vai criar um novo usuário
if ($method == 'POST') {
    // Captura o corpo da requisição (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Verifica se os campos obrigatórios foram enviados
    $camposObrigatorios = ['nome', 'email', 'idade'];
    foreach ($camposObrigatorios as $campo) {
        if (empty($input[$campo])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "O campo '$campo' é obrigatório."]);
            exit();
        }
    }

    // Carrega os usuários
    $usuarios = carregarUsuarios();

    // Variável que vai armazenar o ID
    $id = 1;

    // Verifica se o JSON de usuários está vazio
    if (empty($usuarios)) {
        // Se estiver vazio o ID recebe 1
        $id = 1;
    } else {
        // Percore os usuários e auto incrementa o valor do ID
        foreach ($usuarios as $chaveId => $ids) {
            $idUser = $ids['id'];
            $antigoId = $id;
            if ($idUser >= $antigoId) {
                $id = $antigoId + 1;
            }
        }
    }

    // Variável que armazena o campo ID
    $campoId = ["id" => $id];

    // Adiciona o novo usuário à lista, com o ID junto
    $usuarios[] = $campoId + $input;

    // Salva os usuários atualizados no arquivo JSON
    salvarUsuarios($usuarios);

    // Retorno da lista atualizada
    echo json_encode([
        "message" => "Usuário criado com sucesso!",
        "usuarios" => $usuarios
    ]);
    exit();
}

// Método PUT para atualizar um usuário existente
if ($method == 'PUT') {
    // Captura o corpo da requisição (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Verifica se o campo 'id' foi enviado
    if (!isset($input['id'])) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "O campo 'id' é obrigatório para atualização."]);
        exit();
    }

    // Carrega os usuários existentes
    $usuarios = carregarUsuarios();

    // Procura o usuário pelo ID
    $index = array_search($input['id'], $userId);

    if ($index === false) {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Usuário não encontrado."]);
        exit();
    }

    // Atualizar os dados
    if (isset($input['nome'])) {
        $usuarios[$index]['nome'] = $input['nome'];
    }
    if (isset($input['email'])) {
        $usuarios[$index]['email'] = $input['email'];
    }
    if (isset($input['idade'])) {
        $usuarios[$index]['idade'] = $input['idade'];
    }

    // Salva os usuários atualizados no arquivo
    salvarUsuarios($usuarios);

    echo json_encode(["message" => "Usuário atualizado com sucesso!", "usuarios" => $usuarios]);
    exit();
}

// Deleta todos os usuários
if ($method == 'DELETE' && $uri == '/crud.php/usuarios') {
    // Carrega os usuários
    $usuarios = carregarUsuarios();

    // Usuários são trocados por um array vazio (no caso os usuários "somem/são excluidos")
    $usuarios = [];

    // Salva os usuários (que no caso foram excluidos)
    salvarUsuarios($usuarios);

    // Resposta de sucesso
    echo json_encode(["message" => "Todos os usuários foram deletado com sucesso."]);
    exit();
}

// Método DELETE - Remover um usuário pelo ID
if ($method == 'DELETE' && strpos($uri, '/crud.php/usuarios?id=') === 0)  {
    // Verifica se o ID foi passado na URL
    if (!isset($_GET['id'])) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "O parâmetro 'id' é obrigatório para deletar um usuário."]);
        exit();
    }

    // Pega o valor do parâmetro 'id' enviado por GET
    $id = $_GET['id'];

    // Carrega os usuários salvos no JSON
    $usuarios = carregarUsuarios();

    // Variável index que armazena o indice
    $index = array_search($id, $userId);

    // Resposta de erro se o index retornar falso
    if ($index === false) {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Usuário não encontrado."]);
        exit();
    }

    // Variável que contém o usuário que foi removido
    $usuarioRemovido = $usuarios[$index];

    // Remove o usuário do array
    array_splice($usuarios, $index, 1);

    // Salva o usuário que foi removido
    salvarUsuarios($usuarios);

    // Resposta de sucesso que mostra qual usuário foi deletado
    echo json_encode(["message" => "Usuário deletado com sucesso!", "usuario" => $usuarioRemovido]);
    
    exit();
}

// Resposta padrão caso a rota não seja encontrada
http_response_code(404);
echo json_encode(["error" => "Rota não encontrada"]);