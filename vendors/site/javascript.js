

//controla oo menu principal
function openNav() {
  document.getElementById("mySidenav").style.width = "446px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}


//template ajax--------------------------------------------------¬

function buscarPedido(){

  var baseUrl = document.getElementById('urlBase').value;

  var trackN = document.getElementById('trackN').value;

    //enviando id_produto para obter dados completo do produto
    $.ajax({
      method: 'POST',
      url: baseUrl+'requisicoes/listarPedido',
      data: {trackN:trackN},
      success:function(retornoProduto){
        
        // retornoProduto = jQuery.parseJSON(retornoProduto);      
        
        $('#retornoDados').html(retornoProduto);

      }
    });
};
