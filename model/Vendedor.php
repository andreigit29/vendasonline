<?php
include_once '../conexao/Conexao.php';

class Vendedor extends Conexao{
	private $id;
    private $nome;
    private $email;
    public $conexao = null;

    public function __construct() {
        $conecta = new Conexao();
        $this->conexao = $conecta->Conecta();
    }    

  
    public function insert($obj){
        $array  = [];
    	$sql = "INSERT INTO vendedor(nome, email) VALUES ('{$obj->nome}','{$obj->email}')";
        if (mysqli_query($this->conexao, $sql)) {
            $id = mysqli_insert_id($this->conexao);
            $array[] = $id; $array[] = $obj->nome; $array[] = $obj->email;
        }
        return $array;
	}

	public function update($obj, $id = null){
		$sql = "UPDATE vendedor SET nome = '{$obj->nome}', email = '{$obj->email}' WHERE id = $id ";
            return mysqli_query($this->conexao, $sql);
	}


	public function listaVendedorId($id = null){

	}

	public function listaVendedor(){
        $vendedores = [];
        $sql = 'SELECT * FROM vendedor';
        $resultado = mysqli_query($this->conexao, $sql);
        while($vendedor = mysqli_fetch_assoc($resultado)) {
            array_push($vendedores, $vendedor);
        }
        return $vendedores;
	}

}

?>