<?php
require_once 'header.php';
require 'lib/Meli/meli.php';
require 'configApp.php';
?>

<?php
$meli = new Meli($appId, $secretKey);
$response = $meli->get('/users/me', array('access_token' => $_SESSION['access_token']));

$id_conta = $response['body']->id;

$url = 'orders/search/recent';
$response = "";
$params = [
    'seller' => $id_conta,
//    'status' => 'paid',
    'access_token' => $_SESSION['access_token'],
    'limit' => 25
];
$response = $meli->get($url, $params);
$vendas = $response['body']->results;

?>
<div class="container" style="padding-top: 20px;">
    <div class="row">
        <h3>Lista de Vendas</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Status</th>
                <th scope="col">Valor</th>
                <th scope="col">Data da venda</th>
                <th scope="col">+Detalhes</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vendas as $venda): ?>
                <tr>
                    <th scope="row"><?php echo $venda->id ?></th>
                    <td><?php echo $venda->status ?></td>
                    <td><?php echo "R$ " . number_format($venda->total_amount, 2, ',', '.') ?></td>
                    <td><?php echo date_format(date_create($venda->date_created), 'd-m-Y H:i:s') ?></td>
                    <td>
                        <a href="https://api.mercadolibre.com/orders/<?php echo $venda->id ?>?access_token=<?php echo $_SESSION['access_token'] ?>"
                           target="_blank">+Detalhes</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require_once 'js.php';
require_once 'footer.php';
?>
