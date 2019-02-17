<div class='table-title'> Novo Pedido </div>
<div class="container index">
       <table class="table table-striped">
          <tbody>
             <tr>
                <td colspan="1">
                	<div class="title">
                		<h2><i class="fab fa-wpforms"></i> Dados do Novo Pedido</h2>
                	</div>
                   <form class="well form-horizontal" action="<?php echo base_url('requisicoes/novoPedido'); ?>" method="POST">
                      <fieldset>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Nome</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group">
                               	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                               	<input id="fullName" name="nome" placeholder="Nome Completo" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                       
                        
                           <div class="form-group">
                            <label class="col-md-4 control-label">Telefone</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group">
                               	<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                               	<input id="telefone" name="telefone" placeholder="00 00000000" class="form-control tel" required="true" value="" type="text"></div>
                            </div>
                         </div>

                            <div class="form-group">
                            <label class="col-md-4 control-label">Email</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group">
                               	<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                               	<input id="email" name="email" placeholder="Email" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>

                     <!--     <div class="form-group">
                            <label class="col-md-4 control-label">State/Province/Region</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <input id="state" name="state" placeholder="State/Province/Region" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Postal Code/ZIP</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group">
                               <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                               <input id="postcode" name="postcode" placeholder="Postal Code/ZIP" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div> -->

                        <div class="form-group">
                            <label class="col-md-4 control-label">Quantidade</label>
                            <div class="col-md-8 inputGroupContainer">
                             <div class="input-group">
                             	<span class="input-group-addon"><i class="fas fa-sort-amount-up"></i></span>
                             	<input id="quantidade" name="quantidade" placeholder="1 ou 10 unidades" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>  

                         <div class="form-group">
                            <label class="col-md-4 control-label">Tamanho</label>
                            <div class="col-md-8 inputGroupContainer">
                             <div class="input-group">
                             	<span class="input-group-addon"><i class="fas fa-sort-amount-up"></i></span>
                             	<input id="tamanho" name="tamanho" placeholder="10 15 30 45 " class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                      
                       
                      </fieldset>
                      <div class='form-group'>
                      		<button class='btn btn-primary direita' type="submit">Enviar</button>
                      </div>
                   </form>
                </td>                
             </tr>
          </tbody>
       </table>
    </div>