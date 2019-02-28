<?php
require_once 'header.php';
require 'lib/Meli/meli.php';
require 'configApp.php';
?>

<?php
$meli = new Meli($appId, $secretKey);
$response = $meli->get('/users/me', array('access_token' => $_SESSION['access_token']));

$id_conta = $response['body']->id;

$url = '/users/' . $id_conta . '/items/search';
$response = "";
$response = $meli->get($url, array('access_token' => $_SESSION['access_token']));

//Abaixo pegamos a lista de IDs dos anúncios da nossa conta
$anuncios = $response['body']->results;

$list = array();
//Aqui verificamos se a lista de anúncios não veio vazia
if (!empty($anuncios) && is_array($anuncios)) {
    //Vai pegar informações de cada anúncio separadamente no ML
    foreach ($anuncios as $anuncio) {
        $produto = array();
        $url = '/items/' . $anuncio;
        $response = "";
        $response = $meli->get($url, array('access_token' => $_SESSION['access_token']));

        //Aqui pegamos as informações que queremos de cada anúncio e jogamos para um array $produto
        if ($response['body']->id) {
            $produto = [
                "id" => $response['body']->id,
                "title" => $response['body']->title,
                "thumbnail" => $response['body']->thumbnail,
                "price" => $response['body']->price,
                "permalink" => $response['body']->permalink,
            ];
        }

        //Aqui adicionamos o array produto a lista de produtos que exibiremos no frontend
        if (!empty($produto)) $list[] = $produto;
    }
}

?>
<div class="container" style="padding-top: 20px;">
    <div class="row">
        <?php if (!empty($list)): ?>
            <?php foreach ($list as $produto): ?>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xs-12">
                    <div class="card" style="text-align: center; margin-top: 10px;">
                        <img src="<?php echo $produto['thumbnail'] ?>" class="img-thumbnail rounded mx-auto d-block"
                             alt="imagem-produto" style="width:90px;margin-top: 10px;">

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produto['title'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">ID: <a
                                        href="https://api.mercadolibre.com/items/<?php echo $produto['id'] ?>?access_token=<?php echo $_SESSION['access_token'] ?>"><?php echo $produto['id'] ?></a>
                            </h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Preço:
                                    R$ <?php echo number_format($produto['price'], 2, ",", ".") ?></li>
                            </ul>
                            <div style="padding: 10px;">
                                <a href="<?php echo $produto['permalink'] ?>" target="_blank" class="card-link">Mais
                                    detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nenhum anúncio por enquanto!</h5>
                    <div style="padding: 10px;">
                        <a href="add-product.php" target="_blank" class="card-link">Clique aqui para criar um
                            anúncio rápido</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
require_once 'js.php';
require_once 'footer.php';
?>
