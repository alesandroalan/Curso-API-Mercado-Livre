<?php
require_once 'header.php';
require 'lib/Meli/meli.php';
require 'configApp.php';
?>

<?php
$meli = new Meli($appId, $secretKey);
$response = $meli->get('/users/me', array('access_token' => $_SESSION['access_token']));

$id_conta = $response['body']->id;

$url = 'questions/search';
$response = "";
$params = [
    'seller_id' => $id_conta,
    'status' => 'UNANSWERED',
    'access_token' => $_SESSION['access_token'],
];
$response = $meli->get($url, $params);

//Abaixo pegamos a lista de perguntas da nossa conta
$qtd_perguntas = $response['body']->total;
$perguntas = $response['body']->questions;

//print_r($perguntas);

?>
<div class="container" style="padding-top: 20px;">
    <div class="row">
        <?php if (is_int($qtd_perguntas) && $qtd_perguntas > 0 && !empty($perguntas)): ?>
            <?php foreach ($perguntas as $pergunta): ?>
                <?php
                    $product_url = "";
                    $url = '/items/' . $pergunta->item_id;
                    $anuncio = "";
                    $anuncio = $meli->get($url, array('access_token' => $_SESSION['access_token']));
                    $product_url = $anuncio['body']->permalink;
                ?>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                    <div class="card" style="margin-top: 10px;">
                        <h5 class="card-header">ID Pergunta: <?php echo $pergunta->id ?></h5>

                        <div class="card-body">
                            <h5 class="card-title">Produto:
                                <a href="<?php echo $product_url ?>" target="_blank"><?php echo $pergunta->item_id ?></a>
                            </h5>
                            <p class="card-text"><?php echo $pergunta->text ?></p>
                            <p class="card-text"><textarea id="question-<?php echo $pergunta->id ?>"
                                                           style="width: 100%"></textarea></p>
                            <button class="btn btn-primary" onclick="sendAnswer(<?php echo $pergunta->id ?>)">
                                Responder
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                <div class="card" style="text-align: center;">
                    <div class="card-body">
                        <h5 class="card-title">Nenhuma pergunta para listar!</h5>
                        <div style="padding: 10px;">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
require_once 'js.php';
?>
<script>
    function sendAnswer(question_id) {
        var answer_text = $("#question-" + question_id).val();
        var url = "functions.php";
        $.ajax({
            method: "POST",
            url: url,
            async: false,
            cache: false,
            data: {
                "action": "sendanswer",
                "question_id": question_id,
                "text": answer_text
            },
            success: function (data) {
                if (data.indexOf("Erro") > -1) {
                    console.log(data);
                    alert("Erro ao enviar resposta: Verifique os detalhes do erro no console do navegador em modo desenvolvedor(F12)");
                } else {
                    console.log(data);
                    alert("Resposta enviado com sucesso");
                    location.reload();
                }
            },
            error: function (data) {
                alert("Erro, verifique os detalhes no console do navegador em modo desenvolvedor(F12)");
                console.log(data);
                return false;
            }
        });
    }
</script>
<?php
require_once 'footer.php';
?>
