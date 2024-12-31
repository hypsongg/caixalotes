<?php


header('Content-Type: application/json');
$allowedApiKey = '4243f47260ea29db3dd009e343cdce25';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['cpf']) || empty($input['cpf'])) {
        http_response_code(400);
        echo json_encode(['error' => 'CPF é obrigatório.']);
        exit;
    }

    $cpf = preg_replace('/\D/', '', $input['cpf']); 

    if (strlen($cpf) !== 11) {
        http_response_code(400);
        echo json_encode(['error' => 'CPF inválido.']);
        exit;
    }

    $apiUrl = "https://buscafamiliar.online/api/?usuario=$allowedApiKey&api=cpf&cpf=$cpf";

    // Faz a chamada à API original.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Retorna o resultado da API original.
    http_response_code($httpCode);
    echo $response;
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
