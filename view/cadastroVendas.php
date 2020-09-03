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
                    <div class="col-md-4">
                        <label for="nome">Vendedor:</label>
                        <select name="cboVendedor" id="cboVendedor">
                            <option value="" selected = selected>Selecione um vendedor</option>
                        </select>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-3">
                        <label for="email">Valor:</label>
                        <input type="text" class="form-control" name="valvenda" id="valvenda">
                    </div>
               </div>
              <br>
              <div class="row">
                <div class="col-md-4">
                  <button id="btncadVenda" name="btncadVenda" class="btn btn-primary">Cadastrar</button>
                </div>
              </div>
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


    $('button[name=btncadVenda]').off('click').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var vendedor_id = $(':input[name=cboVendedor] option:selected').val().trim(),
          vl_venda = parseFloat($(':input[name=valvenda]').val().replace(',','.') || 0),
          op = 'insert',
          obj = 'venda'
          params = '';
          $alerta = $('.alerta');

      if (vendedor_id == '') {
          alert('Selecione o vendedor.');
          return false;
      } else if ( (vl_venda == '') || (parseFloat(vl_venda) == 0) ) {
          alert('Preencha a venda.');
          return false;
      }

      params = {
          'operacao': op,
          'objeto': obj,
          'vendedor_id':vendedor_id,
          'valorvenda':vl_venda }

      $.ajax({
        url: 'http://localhost/vendas/api/transacoes.php',
        method: 'POST',
        async: false,
        data: params,
        success: function(data) {
          if (data == 'sucess') {

            $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'Venda cadastrada com sucesso !');

            $alert.insertAfter($alerta);
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