<?php
require_once('cabecalho.php'); ?>    
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Cadastro de Vendas</h2>
            <hr class="my-4">
          </div>
        </div>
        <div style="">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome">Vendedor:</label>
                        <select name="cboVendedor" id="cboVendedor">
                            <option value="" selected = selected>Selecione um vendedor</option>
                        </select>
                        <button id="btnBuscaVend" name="btnBuscaVend" class="btn btn-primary">Listar</button>
                    </div>
                </div>
              
              <br>
              <fieldset id="fdsLista" class="mt-lg" style="display: none;">
                <legend>Vendas Localizadas</legend>
                <div class="table-responsive" id="printContent">
                    <table class="table table-hover table-striped" id="tblLista">
                        <thead>
                            <tr>
                                <th width="5%">Codigo</th>
                                <th width="25%">Nome</th>
                                <th width="25%">Email</th>
                                <th width="10%">Comissão</th>
                                <th width="10%">Vl. Venda</th>
                                <th width="20%">Data Venda</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
              </fieldset>
              
            </form>
        </div>
      </div>
    </section>
<?php
require_once('rodape.php'); ?>    

<script type="text/javascript">
  $(function() {    
    var op = 'list',
        obj = 'vendedor'
        params = '';
        $alerta = $('.alerta'),

      params = {
        'operacao': op,
        'objeto': obj };

      $.ajax({
        url: 'http://localhost/vendas/api/transacoes.php',
        method: 'POST',
        async: false,
        data: params,
        success: function(data) {
          if ( typeof(data) == 'string' ) {
            try { data = JSON.parse(data); }
            catch (e) {
              console.log( e.message );
              $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'occoreu um erro na exibição da listagem.');

                $alert.insertAfter($alerta);
              return false;
            }
          }

          if (!$.isEmptyObject(data) && (typeof(data) == 'array' || typeof(data) == 'object')) {
            for (i in data) {
              var id  = data[i].id,
                  nome   = data[i].nome;

              $('#cboVendedor').append($("<option></option>").attr("value",id).html(data[i].nome) );

            }
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.status+' - '+textStatus);
          $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+jqXHR.status+' - '+textStatus);

            $alert.insertAfter($alerta);
        }
      });


    $('button[name=btnBuscaVend]').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var vendedor_id = $(':input[name=cboVendedor] option:selected').val().trim(),
            op = 'listbyvendedor',
            obj = 'venda'
            params = '';
            $alerta = $('alerta'),
            $fdsLista     = $('#fdsLista'),
            $tblListaTbd  = $('#tblLista > tbody');

        $tblListaTbd.html('');

        params = {
          'operacao': op,
          'objeto': obj,
          'vendedor_id': vendedor_id };
 
        $.ajax({
          url: 'http://localhost/vendas/api/transacoes.php',
          method: 'POST',
          async: false,
          data: params,
          success: function(data) {
            if ( typeof(data) == 'string' ) {
              try { data = JSON.parse(data); }
              catch (e) {
                console.log( e.message );
                $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'occoreu um erro na exibição da listagem.');

                  $alert.insertAfter($alerta);
                return false;
              }
            }

            if (!$.isEmptyObject(data) && (typeof(data) == 'array' || typeof(data) == 'object')) {

              for (i in data) {
                var id  = data[i].venda_id,
                    nome   = data[i].nome,
                    email  = data[i].email,
                    comissao = data[i].vl_comissao,
                    venda = data[i].vl_venda,
                    dt_venda = data[i].data_venda;

                $tblListaTbd.append(
                  '<tr>'+
                  ' <td>'+id+'</td>'+
                  ' <td>'+((nome == null) ? '---' : nome)+'</td>'+
                  ' <td>'+((email == null) ? '---' : email)+'</td>'+
                  ' <td>'+'R$ '+comissao+'</td>'+
                  ' <td>'+'R$ '+venda+'</td>'+
                  ' <td>'+dt_venda+'</td>'+
                  '</tr>'
                );
              }
              $fdsLista.fadeIn(300);
            }

          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.status+' - '+textStatus);
            $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+jqXHR.status+' - '+textStatus);

              $alert.insertAfter($alerta);
          }
        });



    });


  });


</script>