<?php
require_once('cabecalho.php'); ?>    
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Listagem de Vendedor</h2>
            <hr class="my-4">
          </div>
        </div>
        <div style="">
            <form method="POST">
              <fieldset id="fdsLista" class="mt-lg" style="display: block;">
                <legend>Vendedores Encontrados</legend>
                <div class="table-responsive" id="printContent">
                    <table class="table table-hover table-striped" id="tblLista">
                        <thead>
                            <tr>
                                <th width="5%">Codigo</th>
                                <th width="55%">Nome</th>
                                <th width="40%">Email</th>
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
        $fdsLista     = $('#fdsLista'),
        $tblListaTbd  = $('#tblLista > tbody');

      $tblListaTbd.html('');

      params = {
        'operacao': op,
        'objeto': obj };

    // Quando carregar página, carrega listagem
    setTimeout(function () { montaListagem(); }, 1000);

    var montaListagem = function() {
 
      //console.log(params, typeof(params)); return false;
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
                  nome   = data[i].nome,
                  email  = data[i].email;

              $tblListaTbd.append(
                '<tr>'+
                ' <td>'+((id == null) ? '---' : id)+'</td>'+
                ' <td>'+((nome == null) ? '---' : nome)+'</td>'+
                ' <td>'+((email == null) ? '---' : email)+'</td>'+
                '</tr>'
              );

            }
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.status+' - '+textStatus);
          $alert = $('<div></div>').addClass('alert alert-danger').html('<button type="button" data-dismiss="alert" class="close">×</button>'+jqXHR.status+' - '+textStatus);

            $alert.insertAfter($alerta);
        }
      });

      return true;
    };

  });

</script>
