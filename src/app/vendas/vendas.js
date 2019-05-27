(function () {

	'use strict';

	angular
		.module('app.vendas')
		.controller('Vendas', Vendas);

	Vendas.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'vendasRest', 'produtoRest', 'clienteRest'];

	function Vendas(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice, produtoRest, clienteRest) {
		var vm = this;

		vm.listaProdutos = [];
		vm.carrinho = [];
		vm.adicionarProdutoNoCarrinho = adicionarProdutoNoCarrinho;
		vm.aumentarQuantidade = aumentarQuantidade;
		vm.reduzirQuantidade = reduzirQuantidade;
		vm.finalizarVenda = finalizarVenda;

		var dataAuxiliar = new Date();
		dataAuxiliar.setMonth(dataAuxiliar.getMonth() + 1);

		vm.parcelas = [
			{ id: 1, descricao: 'À Vista.'},
			{ id: 2, descricao: 'Parcelar compra em 2 vezes.'},
			{ id: 3, descricao: 'Parcelar compra em 3 vezes.'},
			{ id: 4, descricao: 'Parcelar compra em 4 vezes.'},
			{ id: 5, descricao: 'Parcelar compra em 5 vezes.'},
			{ id: 6, descricao: 'Parcelar compra em 6 vezes.'},
			{ id: 7, descricao: 'Parcelar compra em 7 vezes.'},
			{ id: 8, descricao: 'Parcelar compra em 8 vezes.'},
			{ id: 9, descricao: 'Parcelar compra em 9 vezes.'},
			{ id: 10, descricao: 'Parcelar compra em 10 vezes'}
		];

		vm.venda = { dataPagamento: dataAuxiliar, parcelamento: 1 };

		vm.carrinho = [
			{id_produto: 10, codigo: "002", nome: "TESTE", quantidade: 10, valor: 10, valorTotalProduto: 100},
			{id_produto: 10, codigo: "002", nome: "TESTE 02", quantidade: 10, valor: 10, valorTotalProduto: 100}
		];

		vm.valorTotalCarrinho = 200;

		iniciar();

		function finalizarVenda() {
			dataservice.salvar({ venda: vm.venda, carrinho: vm.carrinho}).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao registrar a venda.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function aumentarQuantidade(produto) {
			produto.quantidade++;
			produto.valorTotalProduto = produto.valor * produto.quantidade;

			vm.valorTotalCarrinho = 0;

			angular.forEach(vm.carrinho, function (value, id) {
				vm.valorTotalCarrinho += (value.valor * value.quantidade)
			});
		}

		function reduzirQuantidade(produto) {
			if (produto.quantidade > 1) {
				produto.quantidade--;
				produto.valorTotalProduto = produto.valor * produto.quantidade;

				vm.valorTotalCarrinho = 0;

				angular.forEach(vm.carrinho, function (value, id) {
					vm.valorTotalCarrinho += (value.valor * value.quantidade)
				});
			} else if (produto.quantidade == 1) {
				for (var i = 0; i < vm.carrinho.length; i++) {
					if (produto.id_produto == vm.carrinho[i].id_produto) {
						vm.carrinho.splice(i, 1);
					}
				}

				vm.valorTotalCarrinho = 0;

				angular.forEach(vm.carrinho, function (value, id) {
					vm.valorTotalCarrinho += (value.valor * value.quantidade)
				});

				controllerUtils.feed(controllerUtils.messageType.INFO, 'Produto removido do carrinho.');
			} 
		}

		function adicionarProdutoNoCarrinho(objeto) {
			var jaExiste = false;

			angular.forEach(vm.carrinho, function (value, id) {
				if (value.id_produto == objeto.id_produto) {
					jaExiste = true;
					controllerUtils.feed(controllerUtils.messageType.INFO, 'Este produto já está no carrinho.');
				}
			});

			if (!jaExiste) {
				vm.carrinho.push({
					id_produto: objeto.id_produto,
					nome: objeto.nome,
					codigo: objeto.codigo,
					quantidade: 1,
					valor: objeto.valor,
					valorTotalProduto: objeto.valor
				});

				vm.valorTotalCarrinho = 0;

				angular.forEach(vm.carrinho, function (value, id) {
					vm.valorTotalCarrinho += (value.valor * value.quantidade)
				});
			}

			delete vm.produtoSelecionado;
		}
		
		function iniciar() {
			buscarTodosProdutos();
			buscarTodosClientes();
		}

		function buscarTodosProdutos() {
			vm.listaProdutos = [];

			produtoRest.buscarTodosProdutos().then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar os produtos.');
			}

			function success(response) {
				vm.listaProdutos = response.data.data.produtos;
			}
		}

		function buscarTodosClientes() {
			vm.listaClientes = [];

			clienteRest.buscarTodosClientes().then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar os clientes.');
			}

			function success(response) {
				vm.listaClientes = response.data.data.clientes;
			}
		}

		function voltar() {
			controllerUtils.$location.path('vendas');
		}
	}

})();