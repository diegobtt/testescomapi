<?php

use app\controllers\HomeController;
use app\controllers\JogadorController;
use app\controllers\TimeController;

$app->get('/',HomeController::class . ':getCustomers');
$app->get('/order',HomeController::class . ':order');
$app->get('/customers',HomeController::class . ':getAndArmazenaCustomer');
$app->get('/transaction_pix',HomeController::class . ':transactionPix');
$app->get('/transaction_card',HomeController::class . ':transactionCard');
$app->get('/transaction_cardobj',HomeController::class . ':transactionCardComOBJ');
$app->post('/webhook',HomeController::class . ':webHook');






/*$app->post('/webhook', function ($request, $response, $args) {

    // Obter o corpo da requisição (os dados enviados pelo webhook)
    $data = $request->getParsedBody();

    // Verificar se os dados foram recebidos corretamente
    if (empty($data)) {
        return $response->withStatus(400)->write('Erro: Nenhum dado enviado.');
    }

    // Aqui você pode processar os dados recebidos, como salvar em banco de dados
    error_log('Dados recebidos no webhook: ' . json_encode($data));

    // Enviar uma resposta indicando que os dados foram recebidos com sucesso
    $response->getBody()->write('Webhook recebido com sucesso.');

    return $response->withStatus(200);
});*/