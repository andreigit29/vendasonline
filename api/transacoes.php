<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../controller/VendedorController.php';
include '../controller/VendaController.php';

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (!empty($_POST)){
	$dados = $_POST;

	if ($dados['objeto'] == 'vendedor') {
		if ($dados['operacao'] == 'insert') {
			try {
				$objDados = (object) $dados;
				unset($objDados->operacao);
				unset($objDados->objeto);
				$objVendedorCtrl = new VendedorController();
				$resultado = $objVendedorCtrl->insert($objDados);
				print_r(json_encode($resultado));
			} catch(\Exception $e) {
				print_r( 'erro: '.$e->getMessage());
			}
			
		} else if ($dados['operacao'] == 'list') {
			try {
				$objVendedorCtrl = new VendedorController();
				$resultado = $objVendedorCtrl->listaVendedor();
				print_r(json_encode($resultado));	
			} catch(\Exception $e) {
				print_r( 'erro: '.$e->getMessage());
			}
			
		}

	} else if ($dados['objeto'] == 'venda') {
		if ($dados['operacao'] == 'insert') {
			try {
				$objDados = (object) $dados;
				unset($objDados->operacao);
				unset($objDados->objeto);
				$objVendaCtrl = new VendaController();
				$resultado = $objVendaCtrl->insert($objDados);
				print_r(json_encode($resultado));	
			} catch(\Exception $e) {
				print_r( 'erro: '.$e->getMessage());
			}
			
		} else if ($dados['operacao'] == 'listbyvendedor') {
			try {
				$objDados = (object) $dados;
				$objVendedorCtrl = new VendaController();
				$resultado = $objVendedorCtrl->listaVendasVendedor($objDados->vendedor_id);
				print_r(json_encode($resultado));	
			} catch(\Exception $e) {
				print_r( 'erro: '.$e->getMessage());
			}
			
		} else if ($dados['operacao'] == 'email') {
			try {
				$totvendas = $totcomissao = 0;
				$linhas = '';
				$objDados = (object) $dados;
				$objVendedorCtrl = new VendaController();
				$resultado = $objVendedorCtrl->listaVendasDia();

				if ($resultado) {
					foreach ($resultado as $key => $venda) {
						$linhas .= '<tr>
					                   <td>'.$venda['venda_id'].'</td>
					                   <td>'.$venda['nome'].'</td>
					                   <td>'.$venda['email'].'</td>
					                   <td>'.$venda['data_venda'].'</td>
					                   <td>'.$venda['vl_comissao'].'</td>
					                   <td>'.$venda['vl_venda'].'</td>
					                </tr>';
					    $totvendas   += (float)$venda['vl_venda'];
					    $totcomissao += (float)$venda['vl_comissao'];
					}

					$totalizador = '<tr>
					                   <td colspan="3"></td>
					                   <td>Total</td>
					                   <td>'.$totcomissao.'</td>
					                   <td>'.$totvendas.'</td>
					                </tr>';

					$table = '<legend>Vendas Efetuadas na data '.date('d/m/Y').'</legend>
				                <div class="table-responsive" id="printContent">
				                    <table class="table table-hover table-striped" id="tblLista">
				                        <thead>
				                            <tr>
				                                <th width="5%">Codigo</th>
				                                <th width="25%">Nome</th>
				                                <th width="25%">Email</th>
				                                <th width="20%">Data Venda</th>
				                                <th width="10%">Comissão</th>
				                                <th width="10%">Vl. Venda</th>
				                            </tr>
				                        </thead>
				                        <tbody>'.$linhas.$totalizador.'</tbody>
				                    </table>
				                </div>';

					$nome = $objDados->nome;
					$email = $objDados->email;

					$destino = $email;
					$assunto = "Relatório de vendas diária";
					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'vendasproduto10@gmail.com';
					$mail->Password = 'vendas@10';
					$mail->SingleTo = true; 
					$mail->Mailer = 'smtp'; 
					$mail->SMTPSecure = 'ssl';
					$mail->Port = 465;
					$mail->IsHTML(true);
					$mail->From = 'vendasproduto10@gmail.com';
					$mail->FromName = 'Sistema';
					$mail->addAddress($email);
					$mail->Subject = $assunto;
					$mail->Body = $table;
					if($mail->Send()):
					    print_r('sucess');
					else:
					    print_r( 'Erro ao enviar Email:' . $mail->ErrorInfo);
					endif;
				}

			} catch(\Exception $e) {
				print_r( 'erro: '.$e->getMessage());
			}
			
		}

	}
}

?>
