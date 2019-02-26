<?php
require_once 'header.php';
require_once 'lib/Meli/meli.php';
require_once 'configApp.php';
?>
<div class="container" style="padding-top: 20px;">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de anúncio</h5>
                    <div class="bootstrap-iso">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form method="post" id="product">
                                        <div class="form-group">
                                            <label class="control-label" for="title">
                                                T&iacute;tulo do an&uacute;ncio
                                            </label>
                                            <input class="form-control" id="title" name="title" type="text" value="Relógio teste - não ofertar"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="desc">
                                                Descrição do anúncio
                                            </label>
                                            <textarea class="form-control" id="desc" name="desc">Descrição do anúncio teste </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="listing_type_id">
                                                Selecione o tipo de anúncio
                                            <select class="select form-control" id="listing_type_id"
                                                    name="listing_type_id">
                                                <option value="bronze">
                                                    bronze
                                                </option>
                                                <option value="gold">
                                                    gold
                                                </option>
                                                <option value="gold_special">
                                                    gold_special
                                                </option>
                                                <option value="gold_pro" selected>
                                                    gold_pro
                                                </option>

                                            </select>
                                            <span class="help-block" id="hint_listing_type_id">
       Consulte todos em: https://api.mercadolibre.com/sites/MLB/listing_types
      </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="pictures">
                                                URL da imagem
                                            </label>
                                            <input class="form-control" id="pictures" name="pictures"
                                                   placeholder="http://domain.com/my-image.jpg" type="text"
                                                   value="https://upload.wikimedia.org/wikipedia/en/f/fd/Touch-watch-phone_4_450.jpg"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="category_id">
                                                ID da categoria
                                            <input class="form-control" id="category_id" name="category_id"
                                                   placeholder="ex: MLB422600" type="text" value="MLB260864"/>
                                            <span class="help-block" id="hint_category_id">
       Escolha a sua categoria em  https://api.mercadolibre.com/sites/MLB/categories
      </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="text2">
                                                Quantidade em estoque
                                            <input class="form-control" id="available_quantity" name="available_quantity" type="number" value="4"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="condition">
                                                Modo da compra
                                            <select class="select form-control" id="buying_mode" name="buying_mode">
                                                <option value="buy_it_now" selected>
                                                    buy_it_now
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="condition">
                                                Moeda
                                            </label>
                                            <select class="select form-control" id="currency_id" name="currency_id">
                                                <option value="BRL" selected>
                                                    BRL
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="condition">
                                                Condi&ccedil;&atilde;o do produto
                                            <select class="select form-control" id="condition" name="condition">
                                                <option value="new" selected>
                                                    Novo
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="site_id">
                                                ID do site
                                            <select class="select form-control" id="site_id" name="site_id">
                                                <option value="MLB" selected>
                                                    MLB
                                                </option>
                                            </select>
                                            <span class="help-block" id="hint_site_id">
       MLB (Mercado Livre Brasil)
      </span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="price">
                                                Pre&ccedil;o
                                            </label>
                                            <input class="form-control" id="price" name="price" value="100" placeholder="100.50"
                                                   type="text"/>
                                        </div>
                                        <div class="form-group">
                                            <div>
                                                <button class="btn btn-primary " id="addprod" type="button">
                                                    Cadastrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
?>
<script>
    $(document).ready(function () {
        $("#addprod").on('click', function () {
            var tipo_anuncio = $("#listing_type_id").val();
            var pic = $("#pictures").val();
            var titulo = $("#title").val();
            var descricao = $("#desc").val();
            var id_categoria = $("#category_id").val();
            var qtd_estoque = $("#available_quantity").val();
            var modo_compra = $("#buying_mode").val();
            var moeda = $("#currency_id").val();
            var condicao = $("#condition").val();
            var site_id = $("#site_id").val();
            var preco = $("#price").val();
            var token = "<?php echo $_SESSION['access_token'] ?>";

            var url = "functions.php";
            $.ajax({
                method: "POST",
                url: url,
                async: false,
                cache: false,
                data: {
                    "access_token": token,
                    "action":"addprodduct",
                    "listing_type_id": tipo_anuncio,
                    "pictures": pic ,
                    "title": titulo,
                    "descricao": descricao,
                    "available_quantity": qtd_estoque,
                    "category_id": id_categoria,
                    "buying_mode": modo_compra,
                    "currency_id": moeda,
                    "condition": condicao,
                    "site_id": site_id,
                    "price": preco
                },
                success: function( data ){
                    if(data.indexOf("Erro") > -1){
                        console.log(data);
                        alert("Erro ao cadastrar: Verifique os detalhes do erro no console do navegador em modo desenvolvedor(F12)");
                    }else {
                        console.log(data);
                        alert("Cadastrado com sucesso");
                    }
                },
                error: function( data ){
                    alert("Erro, verifique os detalhes do erro no console do navegador em modo desenvolvedor(F12)");
                    console.log( data );
                    return false;
                }
            });
        });
    })
</script>
<?php
require_once 'footer.php';
?>
