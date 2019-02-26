<?php
require_once 'header.php';
require 'lib/Meli/meli.php';
require 'configApp.php';
?>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col">
                <?php
                $meli = new Meli($appId, $secretKey);
                $response = $meli->get('/users/me', array('access_token' => $_SESSION['access_token']));

                $id_conta = $response['body']->id;
                $fullname = $response['body']->first_name . " " . $response['body']->last_name;
                $email = $response['body']->email;
                $address = $response['body']->address;
                $phone = $response['body']->phone->number;
                $link = $response['body']->permalink;
                ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $fullname ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted col-5">Conta <?php echo $id_conta ?></h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><?php echo "<b>E-mail:</b> {$email}" ?></li>
                            <li class="list-group-item"><?php echo "<b>Endereço:</b><br>{$address->address}" . "<br>" .
                                    $address->city . "<br>" .
                                    $address->state . "<br>" .
                                    $address->zip_code . "<br>" ?></li>
                            <li class="list-group-item"><?php echo "<b>Fone:</b> {$phone}" ?></li>
                            <li class="list-group-item"><?php echo "<b>Access Token:</b> {$_SESSION['access_token']}" ?></li>
                        </ul>
                        <div style="padding: 10px;">
                            <a href="<?php echo $link ?>" target="_blank" class="card-link">Mais detalhes</a>
                        </div>
                    </div>
                </div>
                <?php
//                echo "<h4>Response</h4>";
//                echo '<pre class="pre-item">';
//                print_r($response);
//                echo '</pre>';
                ?>
            </div>
        </div>
    </div>
<?php
require_once 'js.php';
require_once 'footer.php';
?>
