

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>



<div class='container'>  
  <div class="form-group">
    <label class="col-md-10 control-label"></label>

    <div class="col-md-10">
       <div class="input-group">
          <span class="input-group-addon"><i class="fas fa-search"></i></span>
          <input id="trackN" data-idProduto="" name="trackN" placeholder="Cole o codigo do Pedido" class="form-control" required="true" value="" type="text">
        </div>
       
          <button class='buscarPedido btn' id="buscarPedido" onclick="buscarPedido()"> Buscar 
          </button> <span style="font-size: 12px;">ex: 20181123101231620889</span>
    </div>
  </div>
    <div class="col-md-12 spacer">
      
    </div>
  
  
    <input type="hidden" name="urlBase" class="urlBase" id="urlBase" value="<?php echo base_url(); ?>">    
  
    <div class='retornoDados col-md-12' id="retornoDados">
        

        <!-- Dados do Produto -->

        <div class='col-md-12'>    
        <table class='tabelaPedidos tabelaLocais'>
            <thead class='black white-text'>
              <tr>
                <th scope='col'>Status</th>
                <th scope='col'>Track type</th>                            
                <th scope='col'>CreateTime</th>
                <th scope='col'>TrackStatus </th>
                <th scope='col'>StoreName </th>
                <th scope='col'>CourierName</th>
                <th scope='col'>RatingRating</th>
                                                     
              </tr>
            </thead>
            
            <tbody class='table table-striped' >
              <?php
              
              ?>
            </tbody>
        </table>

    </div>

        <!--  Dados do Produto -->
    </div>  

  </div>
