<?php
include '../model/Vendedor.php';

class VendedorController{
	
	function insert($obj){
		$vendedor = new Vendedor();
		return $vendedor->insert($obj);
	}

	function update($obj,$id){
		$vendedor = new Vendedor();
		return $vendedor->update($obj, $id);
	}

	function listaVendedorId($id = null){

	}

	function listaVendedor(){
		$vendedor = new Vendedor();
		return $vendedor->listaVendedor();
	}
}

?>