<?php
require_once 'lib/Meli/meli.php';
require_once 'configApp.php';

$action = $_POST['action'];

if(empty(session_id())){
    session_start();
}
if ($action == "addprodduct") {

    $tipo_anuncio = $_POST["listing_type_id"];
    $pic = $_POST["pictures"];
    $titulo = $_POST["title"];
    $descricao = $_POST["descricao"];
    $id_categoria = $_POST["category_id"];
    $qtd_estoque = $_POST["available_quantity"];
    $modo_compra = $_POST["buying_mode"];
    $moeda = $_POST["currency_id"];
    $condicao = $_POST["condition"];
    $site_id = $_POST["site_id"];
    $preco = $_POST["price"];

    /*
     * Aqui setamos todas as opções que queremos do anúncio
     * Para consultar os atributos das categorias acesse o link apenas alterando o ID da Categoria
     * https://api.mercadolibre.com/categories/MLB260864/attributes
     */
    $item = array(
        "title" => $titulo,
        "category_id" => $id_categoria,
        "price" => $preco,
        "currency_id" => $moeda,
        "available_quantity" => $qtd_estoque,
        "buying_mode" => $modo_compra,
        "listing_type_id" => $tipo_anuncio,
        "condition" => $condicao,
        "description" => array ("plain_text" => $descricao),
        "warranty" => "12 meses pela fábrica",
        "pictures" => array(
            array(
                "source" => $pic
            )
        ),
//        "shipping" => array(
//            "mode" => "me2",
//            "local_pick_up" => false,
//            "free_shipping" => false,
//            "free_methods" => []
//        ),
        "attributes" => array(
            array(
                "id" => "BRAND",
                "value_name" => "Indefinida"
            ),
            array(
                "id" => "COLOR",
                "value_id" => "52049"
            ),
            array(
                "id" => "WEIGHT",
                "value_name" => "188g"
            ),
            array(
                "id" => "MODEL",
                "value_name" => "123B"
            ),
            array(
                "id" => "ALPHANUMERIC_MODEL",
                "value_name" => "24hs"
            ),
            array(
                "id" => "STRAP_COLOR",
                "value_name" => "Preta"
            ),
            array(
                "id" => "BEZEL_COLOR",
                "value_name" => "Ouro"
            ),
            array(
                "id" => "BACKGROUND_COLOR",
                "value_name" => "Branco"
            ),
            array(
                "id" => "CASE_COLOR",
                "value_name" => "Preto"
            ),
            array(
                "id" => "WRISTWATCH_STRAP_MATERIAL",
                "value_name" => "Borracha"
            ),
            array(
                "id" => "DIAL_COLOR_HOURS",
                "value_name" => "Cinza"
            ),
            array(
                "id" => "DIAL_COLOR_MINUTES_SECONDS",
                "value_name" => "Cinza-escuro"
            ),
            array(
                "id" => "COLOR_SUBDIALS",
                "value_name" => "Preto"
            ),
            array(
                "id" => "COLOR_OF_LIGHT",
                "value_name" => "Azul"
            ),
            array(
                "id" => "DETAILED_MODEL",
                "value_name" => "123Black"
            ),
            array(
                "id" => "WATCH_CASE_MATERIAL",
                "value_name" => "Plástico"
            ),
            array(
                "id" => "WATER_RESISTANCE",
                "value_name" => "Sim"
            ),
            array(
                "id" => "FRAME_MATERIALS",
                "value_name" => "Aço"
            ),
            array(
                "id" => "SEX",
                "value_name" => "Masculino"
            ),
            array(
                "id" => "AGE_GROUP",
                "value_name" => "Adultos"
            ),
            array(
                "id" => "CHRONOGRAPH",
                "value_name" => "Sim"
            ),
            array(
                "id" => "GLASS_TYPE",
                "value_name" => "Acrílico"
            ),
            array(
                "id" => "WATER_RESISTANCE_DEPTH",
                "value_name" => "50m"
            ),
            array(
                "id" => "WATCH_DISPLAY_TYPE",
                "value_name" => "Digital"
            ),
            array(
                "id" => "CALENDAR_TYPE",
                "value_name" => "Dia e data"
            ),
            array(
                "id" => "CLASP_TYPE",
                "value_name" => "Fivela"
            ),
            array(
                "id" => "DUAL_TIME",
                "value_name" => "Sim"
            ),
            array(
                "id" => "SCREEN_DATE",
                "value_name" => "Não"
            ),
            array(
                "id" => "",
                "value_name" => ""
            ),
            array(
                "id" => "",
                "value_name" => ""
            ),

            array(
                "id" => "GTIN",
                "value_name" => "1234564321234"
            ),
        )
    );
    $meli = new Meli($appId, $secretKey);

    try {
        $response = $meli->post('/items', $item, array('access_token' => $_SESSION['access_token']));
        print_r($response);
    } catch (Exception $e) {
        echo "Erro: ". $e->getMessage();
    }
}else if ($action == "sendanswer") {
    $question_id = $_POST["question_id"];
    $text = $_POST["text"];

    $answer = [
      "question_id" => $question_id,
      "text" => $text
    ];

    try {

        $meli = new Meli($appId, $secretKey);
        $response = $meli->post('/answers', $answer, array('access_token' => $_SESSION['access_token']));

        if(isset($response['body']->status) && isset($response['body']->error) && $response['body']->status != 200)
            throw new Exception($response['body']->message);
        print_r($response);
    }catch (Exception $e){
        echo "Erro: ". $e->getMessage();
    }
}else if ($action == "getsuggestion") {
    $title = $_POST["title"];
    $params = [
        [
            "title" => $title
        ]
    ];

    try {

        $meli = new Meli($appId, $secretKey);
        $response = $meli->post('/sites/MLB/category_predictor/predict', $params);
        if(isset($response['body']->status) && isset($response['body']->error) && $response['body']->status != 200)
            throw new Exception($response['body']->message);
        echo json_encode($response['body'][0]);
    }catch (Exception $e){
        echo "Erro: ". $e->getMessage();
    }
}