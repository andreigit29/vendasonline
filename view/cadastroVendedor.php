<?php
require_once('cabecalho.php'); ?>    
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">Cadastro de Vendedor</h2>
            <hr class="my-4">
          </div>
        </div>
        <div style="">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome">Nome do Vendedor:</label>
                        <input type="text" class="form-control" name="nome" id="nome">
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
               </div>
              <br>
              <div class="row">
                <div class="col-md-4">
                  <button id="btncadVendedor" name="btncadVendedor" class="btn btn-primary">Cadastrar</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </section>
<?php
require_once('rodape.php'); ?>    

<script type="text/javascript">
  $('button[name=btncadVendedor]').off('click').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var nomevend = $(':input[name=nome]').val().trim(),
        emailvend = $(':input[name=email]').val().trim(),
        op = 'insert',
        obj = 'vendedor'
        params = '';
        $alerta = $('.alerta');

    if (nomevend == '') {
        alert('Preencha o nome.');
        return false;
    } else if (emailvend == '') {
        alert('Preencha o email.');
        return false;
    }

    params = {
        'operacao': op,
        'objeto': obj,
        'nome':nomevend,
        'email':emailvend }

    $.ajax({
      url: 'http://localhost/vendas/api/transacoes.php',
      method: 'POST',
      async: false,
      data: params,
      success: function(data) {
        if ( typeof(data) == 'string' ) {
          try { data = JSON.parse(data); 
            $alert = $('<div></div>').addClass('alert alert-sucess').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'Vendedor cadastrado com sucesso.');

              $alert.insertAfter($alerta);
          }
          catch (e) {
            $alert = $('<div></div>').addClass('alert alert-danger').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'Ocoreu na inclusão da venda.');

              $alert.insertAfter($alerta);
            return false;
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.status+' - '+textStatus);
        $alert = $('<div></div>').addClass('alert alert-danger').html('<button type="button" data-dismiss="alert" class="close">×</button>'+jqXHR.status+' - '+textStatus);

          $alert.insertAfter($alerta);
      }
    });

  });

</script>