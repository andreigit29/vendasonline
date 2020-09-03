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
                        <label for="nome">Nome:</label>
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
                  <input type="reset" class="btn btn-info" value="Limpar" />
                  <button name="btnEnviar" class="btn btn-primary" value="Enviar">Enviar</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </section>
<?php
require_once('rodape.php'); ?>

<script type="text/javascript">
  $('button[name=btnEnviar]').off('click').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var nomevend = $(':input[name=nome]').val().trim(),
        emailvend = $(':input[name=email]').val().trim(),
        op = 'email',
        obj = 'venda'
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
    // console.log(params, typeof(params)); return false;
    $.ajax({
      url: 'http://localhost/vendas/api/transacoes.php',
      method: 'POST',
      async: false,
      data: params,
      success: function(data) {
        if (data == 'sucess') {
          $alert = $('<div></div>').addClass('alert alert-success').html('<button type="button" data-dismiss="alert" class="close">×</button>'+'Email enviado com sucesso !');

          $alert.insertAfter($alerta);
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