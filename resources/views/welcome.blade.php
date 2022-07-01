<html xmlns="http://www.w3.org/1999/xhtml" lang="pt_BR">
<head>
    <title>KANBAN</title>
    <meta charset="utf-8">
    <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
    <meta http-equiv="Last-Modified" content="<?= gmdate('D, d M Y H:i:s') . ' GMT'; ?>"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
    <meta http-equiv="Cache" content="no-cache"/>
    <meta http-equiv="imagetoolbar" content="no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="rating" content="general"/>
    <meta name="author" content="Sandro Alves Peres"/>
    <meta name="title" content="KANBAN"/>
    <meta name="robots" content="noindex,nofollow"/>
    <meta name="googlebot" content="noindex,nofollow"/>

    <!-- Mobile device meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=4"/>
    <meta name="x-blackberry-defaultHoverEffect" content="false"/>
    <meta name="HandheldFriendly" content="true"/>
    <meta name="MobileOptimized" content="240"/>

    <link rel="shortcut icon" href="./assets/imagens/trello-desktop.jpg" type="image/jpg"/>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="apple-touch-icon" href="./assets/imagens/trello-desktop.jpg" type="image/jpg"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="assets/css/kanban.css"/>

    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript">

        let filters = {
            id_curso: '',
            num_aula: '',
            professor: '',
            ordemPor: '',
            ordenacao : ''
        }

        let cards = {};

        $(document).ready(function(){
            $("#input-filtro-professor").focusout(function(){
                filters.professor = $("#input-filtro-professor").val();
                getCards();
            })

            $('#select-filtro-curso').change(function() {
                let selected = $(this).find(":selected").val();
                filters.id_curso = selected;
                getCards();
            });

            $('#select-filtro-num-aula').change(function(){
                let selected = $(this).find(":selected").val();
                filters.num_aula = selected;
                getCards();
            });

            $('#select-filtro-ordenar-por').change(function (){
                let selected = $(this).find(":selected").val();
                filters.ordemPor = selected;
                getCards();
            })

            $('#ordenacao').change(function (){
                let selected = $(this).find(":selected").val();
                filters.ordenacao = selected;
                getCards();
            });
        })
        function setModal(e){
            let html = $(e.target).parent().parent()
            let index = html.find(".index").text();
            let atual_card = cards[index];
            let data = atual_card.dt_registro.split(" ");
            $(".container-modal").empty();
            $(".container-modal").append(
                '<div class="row">' +
                    '<div class="col-md-8"><b>Registro</b></div>'+
                    '<div class="col-md-2 text-center"><b>Nº Aula</b></div>'+
                    '<div class="col-md-2 text-center"><b>Ano</b></div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-md-8 register-icon">'+
                        "<i class='glyphicon glyphicon-calendar glyphicon-modal'></i>"+ data[0] +
                        "<i class='glyphicon glyphicon-time glyphicon-modal'> </i>" + data[1] +
                    '</div>'+
                    '<div class="col-md-2 text-center">' +
                        "<span class='label label-primary label-aula-modal'>A"+ atual_card.aula +"</span>" +
                    '</div>'+
                    '<div class="col-md-2 text-center">' +
                        "<span class='label label-success label-ano-modal'>"+ atual_card.ano +"</span>" +
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="well">'+
                        '<div class="row"><b>Curso</b></div>'+
                        '<div class="row">'+
                            '<i class="glyphicon glyphicon-education glyphicon-modal"></i>'+ atual_card.curso.curso +
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="row">' +
                    '<ul class="nav nav-tabs">' +
                        '<li role="presentation" class="active"><a href=""><p class="glyphicon glyphicon-user"></p> Professores</a></li>'+
                    '</ul>'+
                '<div class="wrapper-professores">' +
                '<span class="label">Sandro Peres</span>' +
                '<span class="label">Eduardo Souza</span>' +
                '</div>' +
                    '<ul class="nav nav-tabs">' +
                        '<li role="presentation" class="active"><a href=""><p class="glyphicon glyphicon-list-alt"></p> Materiais</a></li>'+
                    '</ul>'+
                    '<div class="wrapper-professores">' +
                        '<span class="glyphicon glyphicon-book" data-toggle="tooltip" data-placement="top" title="Apostila" style="margin-right: 6px"></span>' +
                        '<span class="glyphicon glyphicon-facetime-video" data-toggle="tooltip" data-placement="top" title="Vídeo" style="margin-right: 6px"></span>' +
                        '<span class="glyphicon glyphicon-music" data-toggle="tooltip" data-placement="top" title="Áudio" style="margin-right: 6px"></span>' +
                    '</div>' +
                '</div>'

            );
        }
        function nextStatus(e){
            let html = $(e.target).parent().parent().parent().parent().parent()
            let index = html.find(".index").text();
            let atual_card = cards[index];

            if(atual_card.professores[0] == null){
                alert('Não é possível mover pois não existem professores para esse card')
            }
            let payload = {
                atual_card

            }

            $.ajax({
                url: 'http://localhost/card/update/next',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", payload},
                success: function(data) {

                },
                failed: function (data){
                    alert(data.message)
                }
            });

            getCards();
        }
        function previousStatus(e){
            let html = $(e.target).parent().parent().parent().parent().parent()
            let index = html.find(".index").text();
            let atual_card = cards[index];

            let payload = {
                atual_card

            }

            $.ajax({
                url: 'http://localhost/card/previous',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", payload},
                success: function(data) {

                },
                failed: function (data){

                }
            });
        }
        function getCards(){
            $(".panel-body").empty();
            $(".badge-num-cards").empty();
            $.ajax({
                url: 'http://localhost/search',
                type: 'GET',
                data: filters,
                success: function(data) {
                    cards = data.data;
                    $.each(data.data, function(i, val){
                        if(val.curso !== undefined){
                            $("#cards-"+val.status.id_status).append(
                                '<div class="panel panel-default card">' +
                                '<div class="panel-body">' +
                                '<div class="row">' +
                                '<div class="col-xs-9">' +
                                "<div class='hidden index'>"+ i +"</div>" +
                                "<h5 class='curso'>"+val.curso.curso+"</h5>" +
                                '<div class="wrapper-professores">' +
                                '<span class="label">Sandro Peres</span>' +
                                '<span class="label">Eduardo Souza</span>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-xs-3 text-right">' +
                                "<span class='label label-primary label-num-aula'>A"+val.aula+"</span>" +
                                "<span class='label label-success label-ano'>"+val.ano+"</span>" +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="panel-footer">'+
                                '<span class="glyphicon glyphicon-book" data-toggle="tooltip" data-placement="top" title="Apostila" style="margin-right: 6px"></span>' +
                                '<span class="glyphicon glyphicon-facetime-video" data-toggle="tooltip" data-placement="top" title="Vídeo" style="margin-right: 6px"></span>' +
                                '<span class="glyphicon glyphicon-music" data-toggle="tooltip" data-placement="top" title="Áudio" style="margin-right: 6px"></span>' +
                                '<div class="dropdown pull-right">' +
                                '<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">' +
                                '<span class="glyphicon glyphicon-move"></span>' +
                                'Mover <span class="caret"></span>' +
                                '</a>'+
                                '<ul class="dropdown-menu">' +
                                '<li class="dropdown-header">Ações</li>' +
                                '<li role="separator" class="divider"></li>' +
                                '<li><a onclick="nextStatus(event)">&raquo; Prosseguir</a></li>' +
                                '<li role="separator" class="divider"></li>' +
                                '<li><a onclick="previousStatus(event)" >&laquo; Voltar</a></li>' +
                                '</ul>' +
                                '</div>' +
                                '<a href="" onclick="setModal(event)" class="pull-right open-modal" data-toggle="modal" data-target="#myModal" style="margin-right: 10px">' +
                                '<span class="glyphicon glyphicon-eye-open"></span> Visualizar' +
                                '</a>' +
                                '</div>' +
                                '</div>'
                            );
                        }
                    })

                    $('.panel-1').append("<span class='badge badge-num-cards'>"+ $("#cards-1 .panel-default").length +"</span>");
                    $('.panel-2').append("<span class='badge badge-num-cards'>"+ $("#cards-2 .panel-default").length +"</span>");
                    $('.panel-3').append("<span class='badge badge-num-cards'>"+ $("#cards-3 .panel-default").length +"</span>");
                    $('.panel-4').append("<span class='badge badge-num-cards'>"+ $("#cards-4 .panel-default").length +"</span>");
                }
            });
        }
        $(function (){
            filters.ordenacao = $("#ordenacao").val();
            filters.ordemPor = $("#select-filtro-ordenar-por").val();
            getCards();
        });

        $(document).ready(function(){
            $("a[rel=modal]").click( function(ev){
                ev.preventDefault();

                var id = $(this).attr("href");

                var alturaTela = $(document).height();
                var larguraTela = $(window).width();

                //colocando o fundo preto
                $('#mascara').css({'width':larguraTela,'height':alturaTela});
                $('#mascara').fadeIn(1000);
                $('#mascara').fadeTo("slow",0.8);

                var left = ($(window).width() /2) - ( $(id).width() / 2 );
                var top = ($(window).height() / 2) - ( $(id).height() / 2 );

                $(id).css({'top':top,'left':left});
                $(id).show();
            });

            $("#mascara").click( function(){
                $(this).hide();
                $(".window").hide();
            });

            $('.fechar').click(function(ev){
                ev.preventDefault();
                $("#mascara").hide();
                $(".window").hide();
            });
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>


<body>
<div class="container-fluid">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Visualização do Card</h4>
                </div>
                <div class="modal-body p-2">
                    <div class="container-fluid container-modal">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>

        </div>
    </div>
    <!-- mascara para cobrir o site -->
    <div id="mascara"></div>
    <div id="teste"></div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Curso</label>
                <select id="select-filtro-curso" class="form-control">
                    <option selected disabled></option>
                    @foreach($courses as $course)
                        <option value="{{$course->id_curso}}">{{$course->curso}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-2 col-md-1">
            <div class="form-group">
                <label class="control-label">Nº Aula</label>
                <select id="select-filtro-num-aula" class="form-control">
                    <option selected disabled></option>
                    @for($i=1; $i<=6; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Professor</label>
                <div class="input-group">
                    <input id="input-filtro-professor" type="text" class="form-control"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label">Ordenar por</label>
                <select id="select-filtro-ordenar-por" class="form-control">
                    <option value="ano">Ano</option>
                    <option value="id_curso">Curso</option>
                    <option value="professor">Professor</option>
                    <option value="num_aula">Nº Aula</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <select id="ordenacao" class="form-control">
                    <option value="asc">Crescente</option>
                    <option value="desc">Decrescente</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row card-colunas">
        <div class="col-sm-6 col-md-3">
            <!-- DEMANDA -->
            <!-- *************************************************** -->
            <div class="panel panel-primary coluna">
                <div class="panel-heading">
                    <p class="panel-title panel-1">
                        Demanda
                    </p>
                </div>
                <div id="cards-1" class="panel-body">

                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">

            <!-- MATERIAL RECEBIDO -->
            <!-- *************************************************** -->

            <div class="panel panel-info coluna">
                <div class="panel-heading">
                    <p class="panel-title panel-2">
                        Material Recebido
                    </p>
                </div>
                <div id="cards-2" class="panel-body">

                    <!--                    --><?// include './cards.php'; ?>

                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">

            <!-- EM CONFERÊNCIA -->
            <!-- *************************************************** -->

            <div class="panel panel-danger coluna">
                <div class="panel-heading">
                    <p class="panel-title panel-3">
                        Em Conferência
                    </p>
                </div>
                <div id="cards-3" class="panel-body">

                    <!--                    --><?// include './cards.php'; ?>

                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">

            <!-- CONFERIDO -->
            <!-- *************************************************** -->

            <div class="panel panel-success coluna">
                <div class="panel-heading">
                    <p class="panel-title panel-4">
                        Conferido
                    </p>
                </div>
                <div id="cards-4" class="panel-body">
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
