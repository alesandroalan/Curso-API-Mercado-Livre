<?php
require_once 'header.php';
require 'lib/Meli/meli.php';
require 'configApp.php';
?>

<div class="container" style="padding-top: 20px;">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
            <div class="card" style="margin-top: 10px;">
                <h5 class="card-header">Sugestão de categorias</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" placeholder="Informe um título detalhado"
                                   id="title">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" onclick="getSuggestion();">Buscar sugestão</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
            <div class="card" style="margin-top: 10px; display: none;" id="card-response">
                <div class="card-body" id="suggestions">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'js.php';
?>
<script>
    var retorno = "";
    function getSuggestion() {
        var title = $("#title").val();
        var url = "functions.php";
        $.ajax({
            method: "POST",
            url: url,
            async: false,
            cache: false,
            data: {
                "action": "getsuggestion",
                "title": title
            },
            success: function (data) {
                if (data.indexOf("Erro") > -1) {
                    console.log(data);
                    alert("Erro: Verifique os detalhes no console do navegador em modo desenvolvedor(F12)");
                } else {
                    data = $.parseJSON(data);
                    console.log(data);
                    var path = "<nav aria-label=\"breadcrumb\">";
                    path += "<ol class=\"breadcrumb\">";
                    if(data.path_from_root.length > 0){
                        for(var i=0;i < data.path_from_root.length; i++ )
                        path += "<li class=\"breadcrumb-item\"><a href=\"#\">"+data.path_from_root[i].name+"</a></li>";
                    }
                    path += "</ol>";
                    path += "</nav>";
                    var probclass = "bg-danger";
                    if(data.prediction_probability >= 0.3 && data.prediction_probability < 0.5)
                        probclass = "bg-warning";
                    else if(data.prediction_probability >= 0.5 && data.prediction_probability < 0.8)
                        probclass = "bg-info";
                    else if(data.prediction_probability >= 0.8)
                        probclass = "bg-success";

                    var response = '<div class="card">';
                    response += '<ul class="list-group list-group-flush">';
                    response += '<li class="list-group-item"><b>Nome: </b>'+data["name"]+'</li>';
                    response += '<li class="list-group-item"><b>ID: </b>'+data.id+'</li>';
                    response += '<li class="list-group-item"><b>Probabilidade: </b>'+ data.prediction_probability;
                    response += '<div class="progress"><div class="progress-bar '+probclass+'" role="progressbar" style="width: '+data.prediction_probability*100+'%" aria-valuenow="'+data.prediction_probability+'" aria-valuemin="0" aria-valuemax="1"></div></div></li>';
                    response += '<li class="list-group-item"><b>Árvore: </b>'+ path+'</li>';
                    response += '</ul>';
                    response += '</div>';

                    $("#suggestions").html(response);
                    $("#card-response").show();
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
