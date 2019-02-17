// Datepicker
$(document).ready(function(){

	$('.datepicker').datepicker(
		{
			format: 'dd/mm/yyyy',                
			language: 'pt-BR',
			autoclose: true,
			todayHighlight: true
		}
	);
	
});

// Marcar página como active no menu
$(document).ready(function(){
	
	let pagina = $('input[name=page]').val();
	

	// Efetuar buscas nos menus (sem ser dropdown)
	$('#menu_lateral ul li').each(function(){
		
		if( pagina == $(this).find('a').attr('id') ){
			$(this).addClass('active');
		}else{
			$(this).removeClass('active');
		}
		
	});

	// Variavel pagina pega o nome da view passada pelo controlle, pesquisa nas ID da tag a no menu da Página MASTER e coloca o elemento como ativo
	//alert(pagina);

	// Efetuar buscas nos menus (itens dropdown)
	$('#menu_lateral ul li.dropdown > ul > li').each(function(){

		if( pagina == $(this).find('a').attr('id') ){
			$(this).addClass('active');

			$(this).closest('ul').addClass('show');
			$(this).closest('ul').closest('li').addClass('active');

		}
		
	});
	
});

// Mostrar menu responsivo
$(document).ready(function(){
	
	$('#btn-responsivo').on('click', function(){
		
		if($('#menu_lateral').hasClass('active-menu-responsive')){
			
			$('#menu_lateral').removeClass('active-menu-responsive');
			
			$('html, body').css({
				overflow: 'auto'
			});
			
		}else{
			
			$('#menu_lateral').addClass('active-menu-responsive');
			
			$('html, body').css({
				overflow: 'hidden'
			});
			
		}

		return false;
		
	});
	
});

// Limpar formulários
$(document).ready(function(){

	$('.clear-form').on('click', function(e){
		e.preventDefault();

		let theForm = $(this).closest('form');

		theForm.find('input').val('');
		theForm.find('select').val('');
		theForm.find('textarea').val('');
		theForm.find('input[type=radio]').prop('checked', false);
		theForm.find('input[type=checkbox]').prop('checked', false);

		return false;
	});

});

// Item de menu Dropdown
$(document).ready(function(){

	$('a.dropdown-item').on('click', function(e){
		e.preventDefault();

		let elementHref = $(this).find('i.fa-caret-down');

		let theList = $(this).siblings('ul');
		let totalSize = 0;

		theList.find('li').each(function(){
			totalSize = totalSize + $(this).height();
		});

		if(theList.hasClass('show')){
			theList.removeClass('show');
			theList.css('height', '0px');

			elementHref.css('transform', 'rotate(0deg)');
		}else{
			theList.addClass('show');
			theList.css('height', totalSize + 'px');

			elementHref.css('transform', 'rotate(180deg)');
		}

		return false;
	});

});

// Asterisco em campos obrigatórios
$(document).ready(function(){

	$('form').find('input, select, textarea').each(function(){

		if( $(this).attr('required') == 'required' ){
			$(this).siblings('label').append('<span class="campo_obrigatorio">*</span>');
		}

	});

	return false;

});

// BUSCA CEP
$(document).ready(function(){


	$('form #endereco_cep').on('blur', function(){
		
		// Salva em variavel o campo que receberá os icones animados
		var campoLoad = $(this).siblings('.status_cep');

		// Aplica o icone de LOAD
		campoLoad.html('<i class="fas fa-spinner fa-spin"></i>');

		// Resgata o CEP informado
		let cep = $(this).val();
		cep = cep.replace('-','');

		// Identifica se o CEP é valido
		if(cep.length == 8){

			// Inicia a requisição
			var request = $.ajax({
				url: "https://viacep.com.br/ws/" + cep + "/json/",
				method: "GET"
			});
			
			// Caso dê certo
			request.done(function( msg ) {

				if(msg.erro == true){

					// CEP não encontrado
					campoLoad.html('<i class="fas fa-times fa-error"></i>');

					$('#endereco_rua').val('');
					$('#endereco_bairro').val('');
					$('#endereco_estado').val('');
					$('#endereco_cidade').val('');

					$('#endereco_rua').prop('readonly', false);
					$('#endereco_bairro').prop('readonly', false);
					$('#endereco_estado').prop('readonly', false);
					$('#endereco_cidade').prop('readonly', false);

				}else{

					// CEP encontrado
					campoLoad.html('<i class="fas fa-check fa-success"></i>');

					$('#endereco_rua').val(msg.logradouro);
					$('#endereco_bairro').val(msg.bairro);
					$('#endereco_estado').val(msg.uf);
					$('#endereco_cidade').val(msg.localidade);

					$('#endereco_rua').prop('readonly', true);
					$('#endereco_bairro').prop('readonly', true);
					$('#endereco_estado').prop('readonly', true);
					$('#endereco_cidade').prop('readonly', true);

				}

				
			});
			
			// Caso dê errado
			request.fail(function( jqXHR, textStatus ) {
				
				campoLoad.html('<i class="fas fa-times fa-error"></i>');

				$('#endereco_rua').val('');
				$('#endereco_bairro').val('');
				$('#endereco_estado').val('');
				$('#endereco_cidade').val('');

				$('#endereco_rua').prop('readonly', false);
				$('#endereco_bairro').prop('readonly', false);
				$('#endereco_estado').prop('readonly', false);
				$('#endereco_cidade').prop('readonly', false);

			});


		}else{

			campoLoad.html('<i class="fas fa-times fa-error"></i>');

			$('#endereco_rua').val('');
			$('#endereco_bairro').val('');
			$('#endereco_estado').val('');
			$('#endereco_cidade').val('');

			$('#endereco_rua').prop('readonly', false);
			$('#endereco_bairro').prop('readonly', false);
			$('#endereco_estado').prop('readonly', false);
			$('#endereco_cidade').prop('readonly', false);
		}

	});

	


});

// Verificações de formulário (AJAX)
$(document).ready(function(){

	// Verificar se o CNPJ já existe
	var cnpjStart = $('.cnpj').val();
	$('.cnpj').on('blur', function(){

		let urlAjax 	= $('input[name=base_url]').val();
		let cnpjValue 	= $(this).val();

		if( cnpjStart != cnpjValue ){
					
			// Inicia a requisição
			var request = $.ajax({
				url: urlAjax + '/Ajax/verificarCNPJ/',
				method: "POST",
				data: {cnpj: cnpjValue}
			});
			
			// Caso dê certo
			request.done(function( msg ) {
				var msg = jQuery.parseJSON(msg);
				
				if(msg.status != false){

					$('button[type=submit]').prop('disabled', true);

					let titulo 	= 'O CNPJ já está cadastrado no sistema.';
					let texto	= 'Não é possível cadastrar empresas com CNPJ iguais.';
					let btn1	= 'Fechar';
					let btn2	= 'Visualizar empresa';
					let acao 	= urlAjax + 'clientes/dados/' + msg.status;

					alertaErro(titulo, texto, btn1, btn2, acao);

				}else{

					$('button[type=submit]').prop('disabled', false);

				}

			});

		}else{
			$('button[type=submit]').prop('disabled', false);
		}

	});

	// Verificar se o usuário já existe
	var loginStart = $('.login').val();
	$('.login').on('blur', function(){

		let urlAjax 	= $('input[name=base_url]').val();
		let loginValue 	= $(this).val();

		if( loginStart != loginValue ){
					
			// Inicia a requisição
			var request = $.ajax({
				url: urlAjax + '/Ajax/verificarLogin/',
				method: "POST",
				data: {login: loginValue}
			});
			
			// Caso dê certo
			request.done(function( msg ) {
				var msg = jQuery.parseJSON(msg);
				
				if(msg.status != false){

					$('button[type=submit]').prop('disabled', true);

					let titulo 	= 'O usuário informado já está cadastrado no sistema.';
					let texto	= 'Não é possível cadastrar mais de um usuário com o mesmo login.';
					let btn1	= 'Fechar';
					let btn2	= 'Visualizar usuário';
					let acao 	= urlAjax + 'usuarios/alterar-usuario/' + msg.status;

					alertaErro(titulo, texto, btn1, btn2, acao);

				}else{

					$('button[type=submit]').prop('disabled', false);

				}

			});

		}else{
			$('button[type=submit]').prop('disabled', false);
		}

	});

});

// Alerta ao excluir
$(document).ready(function(){

	$('a.excluir').on('click', function(e){

		e.preventDefault();

		let titulo 	= 'Deseja deletar o registro?';
		let texto	= '';
		let btn1	= 'Não';
		let btn2	= 'Sim';
		let acao 	= $(this).attr('href');

		alertaExcluir(titulo, texto, btn1, btn2, acao);

	});

});

// Gerar senha
$(document).ready(function(){

	$('#gerarSenha').on('click', function(){

		var inputPass 	= $('#senha');
		var number		= Math.floor((Math.random() * 10000) + 1);
		number 			= number.toString().substr(1, number.length);
		var alfa		= '';
		var possible 	= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for(var i = 0; i < 5 ; i++){
			alfa += possible.charAt(Math.floor(Math.random() * possible.length));
		}

		inputPass.text(alfa.trim() + number.trim());
		inputPass.val(alfa.trim() + number.trim());
		inputPass.attr('type', 'text');

		console.log(inputPass.attr('disabled'));

		if( inputPass.attr('disabled') == 'disabled' ){
			inputPass.prop('disabled', false);
		}

		return false;

	});

});

// funcoes para textos de ajuda
function showhelp(){
	var helpIcon = document.getElementById('ajudaOculta');
	helpIcon.style.transition="0.3s";
	helpIcon.style.visibility= "visible";
	
}
function hidehelp(){
	var helpIcon = document.getElementById('ajudaOculta');
	helpIcon.style.transition="0.3s";
	helpIcon.style.visibility= "hidden";	
}

$(function(){
	$('[data-toggle="tooltip"]').tooltip()
});


// SWEET ALERT

function alertaErro(titulo, texto, btn1, btn2, acao){

	swal({
		title: titulo,
		text: texto,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger',
		confirmButtonText: btn2,
		cancelButtonText: btn1,
		closeOnConfirm: false
	},function(){
		window.location.href = acao;
	});
}

function alertaSucesso(titulo, texto, btn1, btn2, acao){

	swal({
		title: titulo,
		text: texto,
		type: "success",
		showCancelButton: true,
		confirmButtonClass: 'btn-success',
		confirmButtonText: btn2,
		cancelButtonText: btn1,
		closeOnConfirm: false
	},function(){
		window.location.href = acao;
	});
}

function alertaExcluir(titulo, texto, btn1, btn2, acao){

	swal({
		title: titulo,
		text: texto,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: 'btn-warning',
		confirmButtonText: btn2,
		cancelButtonText: btn1,
		closeOnConfirm: false
	},function(){
		window.location.href = acao;
	});

}



/*------------------------ PRODUTOS -------------------*/

$(document).ready(function(){

	$('select[name=categoria]').on('change', function(){

		var selectSubCateg 	= $('select[name=subcategoria]');
		var idCateg 		= $(this).val();
		let urlAjax 		= $('input[name=base_url]').val();

		// Esvaziando options
		selectSubCateg.empty();
		selectSubCateg.prop('disabled', true);
		selectSubCateg.append(new Option("Aguarde...", ""));
					
		// Inicia a requisição
		var request = $.ajax({
			url: urlAjax + '/Ajax/buscaSubcategorias/',
			method: "POST",
			data: {id_categoria: idCateg}
		});
		
		// Caso dê certo
		request.done(function( msg ) {

			var msg 	= jQuery.parseJSON(msg);

			// Esvaziando options novamente
			selectSubCateg.empty();

			if( msg.status == true){

				selectSubCateg.append(new Option("Selecione uma opção...", ""));
				var objects = msg.return;
				$.each(objects, function(index, value) {
					selectSubCateg.append(new Option(value.nome_subcategoria, value.id_subcategoria));
				});

				selectSubCateg.prop('disabled', false);

			}else{
				selectSubCateg.append(new Option("Não há subcategorias cadastradas.", ""));

				selectSubCateg.prop('disabled', true);
			}

			

		});

	});

});

// Duplicar campos de locais
$(document).ready(function(){

	$('#btnNovoLocal').on('click', function(){

		// Pegando o item para clonar os campos
		let row 	= $('.row-estoque:first');
		let ordem	= $('.row-estoque:last').attr('data-ordem');
			ordem 	= parseInt(ordem) + 1;

		let clone 	= row.clone();
		clone.attr('data-ordem', ordem);
		clone.find('select[name=local_fanart]').attr('name', 'local_fanart_' + ordem);
		clone.find('select[name=local_fanart_' + ordem + ']').val('1');
		clone.find('input[name=descricao_local]').attr('name', 'descricao_local_' + ordem);
		clone.find('input[name=descricao_local_' + ordem + ']').val('');
		clone.find('input[name=quantidade_local_estoque]').attr('name', 'quantidade_local_estoque_' + ordem);
		clone.find('input[name=quantidade_local_estoque_' + ordem + ']').val('0');
		
		// Insere por último na lista
		$('.row-estoque:last').after(clone);
	});

});

// Script para determinar a quantidade de produtos em estoque
function calcGuarda(){
	
	var qntTotal	= $('#quantidade_total_produto');
	var qntUso 		= $('#quantidade_uso_produto');
	var qntGuarda 	= $('#quantidade_guarda_produto');
	var auxAlocados = 0;

	$('.quantidade_local_estoque').each(function(){
		auxAlocados = parseInt(auxAlocados) + parseInt($(this).val());
	});

	qntUso.val( parseInt(qntTotal.val()) - parseInt(auxAlocados) );
	qntGuarda.val(parseInt(auxAlocados));

};


// ESTE PEDAÇO CONTROLA AS FUNÇÕES DE LISTAGEM E GRADE DA LISTA DE ITENS NA TELA DE PRODUTOS PARA TRANSPORTE

// Get the elements with class="column"
var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;

// List View
function listView() {
  for (i = 0; i < elements.length; i++) {
	elements[i].style.width = "100%";
	elements[i].style.textAlign ="left";
	elements[i].style.marginLeft = "20px";
	
  }
}

// Grid View
function gridView() {
  for (i = 0; i < elements.length; i++) {
	elements[i].style.width = "50%";
	elements[i].style.textAlign ="";
	elements[i].style.marginLeft = "";
  }
}

//CONTROLA A GRID VIEW E A LIST VIEW preparadas, mas desativadas
/* Optional: Add active class to the current button (highlight it) */
// var container = document.getElementById("btnContainer");
// var btns = container.getElementsByClassName("btn");
// for (var i = 0; i < btns.length; i++) {
//   btns[i].addEventListener("click", function(){
//     var current = document.getElementsByClassName("active");
//     current[0].className = current[0].className.replace("active", "");
//     this.className += "active";
//   });
// }


//permite filtrar os produtos, permitir adicionar os resultados da busca ao carrinho
$(function(){
	$('#busca').keyup(function(){
		var buscaTexto = $(this).val();
		var baseUrl = document.getElementById('urlBase').value;
		//inicia pesquisa assincrona de itens a partir de três caracteres digitados
		if(buscaTexto.length >= 3){
			$.ajax({
				method: 'POST',
				url: baseUrl+'Carrinho/listarProduto',
				data: {nome_produto: buscaTexto},
				success:function(retorno){
					retorno = jQuery.parseJSON(retorno);
					
					$('#contentConteudo').html(retorno);				
				}
			});
		}
	});
});

//preciso permitir que os produtos sejam adicionados mesmo sem realizar a filtragem
$('.adicionar').on('click',function(){
	var baseUrl = document.getElementById('urlBase').value;
	var id_produto = $(this).attr("data-idProduto");
	var btnAdd = $(this).attr('style', 'visibility: hidden');	

		//enviando id_produto para obter dados completo do produto
		$.ajax({
			method: 'POST',
			url: baseUrl+'Carrinho/adicionarProduto',
			data: {id_produto},
			success:function(retornoProduto){
				
				retornoProduto = jQuery.parseJSON(retornoProduto);			
				
				$('#retornoProdutos').html(retornoProduto);

			}
	  });
});


//carrega o carrinho a partir do momento que clica no botão
$('.verItens').on('click',function(){
	var baseUrl = document.getElementById('urlBase').value;

		$.ajax({
			method: 'POST',
			url: baseUrl+'Carrinho/carregaCarrinho',
			success:function(ativeCart){
				ativeCart = jQuery.parseJSON(ativeCart);
				console.log(ativeCart);
				$('#retornoProdutos').html(ativeCart);
			}
		});
		
	  });
