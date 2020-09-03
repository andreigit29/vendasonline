<?php
include_once '../conexao/Conexao.php';

class Venda extends Conexao{
	private $id;
    private $nome;
    private $email;
    private $vl_comissao;
    public $conexao = null;

    public function __construct() {
        $conecta = new Conexao();
        $this->conexao = $conecta->Conecta();
    }    

    private function calculaComissao($percent, $vl_venda) {
        $this->vl_comissao = (float)$vl_venda * ((float)$percent/100);
        return $this->vl_comissao;
    }
 
    public function insert($obj){
        $comissao = $this->calculaComissao('8.5', $obj->valorvenda);
    	$sql = "INSERT INTO venda(vendedor_id, vl_venda, comissao, vl_comissao) VALUES ({$obj->vendedor_id}, {$obj->valorvenda}, 8.5, $comissao)";
        if (mysqli_query($this->conexao, $sql)) {
            $id = mysqli_insert_id($this->conexao);

            $array[] = $id;
            
            $sql_vendedor = "SELECT * FROM vendedor where id = {$obj->vendedor_id}";
            $resultVend = mysqli_query($this->conexao, $sql_vendedor);
            while($vendedor = mysqli_fetch_assoc($resultVend)) {
                $array[] = $vendedor['nome'];
                $array[] = $vendedor['email'];
                $array[] = $comissao;
                $array[] = $obj->valorvenda;
                $array[] = date('d/m/Y H:i:s');
            }

        }
        return $array;

	}

	public function update($obj, $id = null){
        $comissao = calculaComissao('8.5', $obj->vl_venda);
		$sql = "UPDATE venda SET vl_venda = '{$obj->valorvenda}', vl_comissao = $comissao WHERE id = $id ";
            return mysqli_query($this->conexao, $sql);
	}


	public function listaVendaId($id = null){

	}

    public function listaVendasVendedor($vendedor_id = null){
        $vendas = [];
            $sql = "SELECT vl.id as venda_id, ve.nome, ve.email, vl.vl_comissao, vl.vl_venda, vl.data_venda FROM venda vl inner join vendedor ve on (vl.vendedor_id=ve.id) where vl.vendedor_id = $vendedor_id order by data_venda desc";
        $resultado = mysqli_query($this->conexao, $sql);
        while($venda = mysqli_fetch_assoc($resultado)) {
            array_push($vendas, $venda);
        }
        return $vendas;
    }    

    public function listaVendasDia(){
        $vendas = [];
        $data = date('Y-m-d');
            $sql = "SELECT vl.id as venda_id, ve.nome, ve.email, vl.vl_comissao, vl.vl_venda, vl.data_venda FROM venda vl inner join vendedor ve on (vl.vendedor_id=ve.id) where CAST(vl.data_venda AS DATE) = '$data'  order by data_venda";
        $resultado = mysqli_query($this->conexao, $sql);
        while($venda = mysqli_fetch_assoc($resultado)) {
            array_push($vendas, $venda);
        }
        return $vendas;
    }        

	public function listaVendas(){
        $vendas = [];
        $sql = 'SELECT * FROM venda';
        $resultado = mysqli_query($this->conexao, $sql);
        while($venda = mysqli_fetch_assoc($resultado)) {
            array_push($vendas, $venda);
        }
        return $vendas;
	}

}

?>