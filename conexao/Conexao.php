<?php

class Conexao{

	var $usuario = 'root';
	var $senha = '';
	var $host = 'localhost';
	var $banco = 'vendas';
  var $link = null;  	

    function __construct(){
        // $this::Conecta();
    }  

	public function Conecta(){
      

  		$this->link = mysqli_connect($this->host, $this->usuario, $this->senha, $this->banco);

  		if (!$this->link)
  		{
  			die("Erro ao conectar com o Banco de Dados");
  		} else {
          return $this->link;
    }
	}
 	
  public function desconecta(){
      return mysqli_close($this->link);
  }  

}
?>