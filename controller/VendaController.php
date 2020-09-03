<?php
include '../model/Venda.php';

class VendaController{
	
	function insert($obj){
		$venda = new Venda();
		return $venda->insert($obj);
	}

	function update($obj,$id){
		$venda = new Venda();
		return $venda->update($obj, $id);
	}

	function listaVendaId($id = null){

	}

	function listaVendas(){
		$venda = new Venda();
		return $venda->listaVendas();
	}

	function listaVendasDia(){
		$venda = new Venda();
		return $venda->listaVendasDia();
	}	

	function listaVendasVendedor($vendedor_id){
		$venda = new Venda();
		return $venda->listaVendasVendedor($vendedor_id);
	}	
}

?>