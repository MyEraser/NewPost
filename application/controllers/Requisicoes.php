<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*


- Comunicar com a API para gerar pedidos, 
- Consultar dados do pedido,
- Consultar lista de terminais,
- Criar um mapa com a lista dos terminais disponíveis, utilizando o Google maps API ou similar

*/

class Requisicoes extends CI_Controller {
    protected $apiKey = "41bd3dbb4b858427469812b03245fc82";
    
    protected $storeUrl = "testserver.newpost.com/ponte/store";
    protected $appInterfaceUrl = "http://testserver.newpost.com/sistema_cn/api/logistics/appinterface";
    protected $appStoreInterface = "http://testserver.newpost.com/sistema_cn/api/logistics/storeinterface";

    protected $aplicationNovoPedidoNumber = "3001";
    protected $aplicationDetalhesDoPedidoNumber = "3006";
    protected $aplicationListarTerminaisNumber = "3007";
    protected $aplicationLoginUsuario = "2002";
    
	public function __construct(){
		parent::__construct();
		$this->load->model('Model_CRUD','crud');

        $this->load->library('table');

	}

	public function index(){

		$this->load->view('layouts/header');
		$this->load->view('layouts/mainLayout');
	}

  public function formNovoPedido(){
        $this->load->view('layouts/header');
        $this->load->view('layouts/mainLayout');
        $this->load->view('pedidos/pedido_novo');
  }

    public function listarPedidoForm(){
        $this->load->view('layouts/header');
        $this->load->view('layouts/mainLayout');
        $this->load->view('pedidos/pedido_listar');

    }

    public function novoPedido(){
           $dadosPedido =  $this->processaDadosPedido();


            $curl = curl_init();

                  curl_setopt_array($curl, array(
                    CURLOPT_URL => $this->storeUrl,                        
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POST => true,                        
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        
                                ),
                    //para fazer um novo pedido usaremos estes campos da array abaixo
                    CURLOPT_POSTFIELDS => json_encode( 
                        array(                       
                        "Application"=> $this->aplicationNovoPedidoNumber,
                        "ApiKey"=> $this->apiKey,
                        "Param"=> array(
                            "OrderNumber"=> "TESTEPRAIA4",
                            "CourierCode"=> "000001",
                            "TerminalSN"=> "1830111-01",
                            "PhoneNumber"=> $dadosPedido['PhoneNumber'],
                            "Nickname"=> $dadosPedido['Nickname'],
                            "Email"=> $dadosPedido['Email'],
                            "Quantity"=> $dadosPedido['Quantity'],
                            "Size"=> $dadosPedido['Size']
                        ),
                        )
                    ),
                    
                    ));

                               
                    //------------------------------------------------------------------------------
                    echo $resultado = curl_exec($curl);
                            
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                      echo "cURL Error #:" . $err;
                      //encaminha para a view de pedido não realizado
                    } else {
                      echo $resultado;
                      //encaminha para a view de pedido realizado
                     header('Location:'.base_url('requisicoes/pedidoRealizado'));

                    } 
    
    }

    public function pedidoRealizado(){
      $this->load->view('layouts/header');
      $this->load->view('pedidos/pedido_realizado');
    }

    //aqui vou estrutura uma array para enviar para o jason depois
    public function processaDadosPedido(){
        //para fins eventuais
        /* 
        $orderNumber = $this->input->post('OrderNumber');
        $courierCode = $this->input->post('CourierCode');
        $terminalSN =  $this->input->post('TerminalSN');
        */

        $phoneNumber = $this->input->post("telefone");
        //nome da pessoa
        $nickname =    $this->input->post("nome");
        //email pessoal
        $email =       $this->input->post("email");
        $quantidade =  $this->input->post("quantidade"); 
        $tamanho =     $this->input->post("tamanho");

       return $arrayPedido = array(
                 "OrderNumber"=> "TESTEPRAIA4",
                 "CourierCode"=> "000001",
                 "TerminalSN"=> "1830111-01",
                 "PhoneNumber"=> $phoneNumber,
                 "Nickname"=> $nickname,
                 "Email"=> $email,
                 "Quantity"=> $quantidade,
                 "Size"=> $tamanho
        );
    }

    public function listarPedido(){
          $trackNo = $this->input->post("trackN");

          $curl = curl_init();

                  curl_setopt_array($curl, array(
                  CURLOPT_URL => $this->appStoreInterface,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => false,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => array('pRequest' => '{"Application":"3006","ApiKey":"4545e905dc9307a6c6d6d0fc6e706fb0","Param":{"TrackNo":"'.$trackNo.'"}}'),
                ));
              
                   
            //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
            $resultado = curl_exec($curl);
                    
            $err = curl_error($curl);
        
            curl_close($curl);
        
            if ($err) {
              echo "cURL Error #:" . $err;
              //encaminha para a view de pedido não realizado
            } else {
               $resultado;

              $convertArray = $this->recolheJason($resultado);

              echo "<pre>";
              print_r($convertArray);

              $arrayPedidoDados = "";

                  foreach ($convertArray as $key => $value) {
                    
                    $arrayPedidoDados .= "<td>".$value['Status']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['TrackNo']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['TrackType']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['CreateTime']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['TrackStatus']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['StoreName']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['CourierName']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['Rating']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['ReverseCode']."<td>";
                    $arrayPedidoDados .= "<td>".$value['Result']['ReverseTime']."<td>";
                  }

              $tablePedidos = "
                     <!-- Dados do Produto -->

                        <div class='col-md-12'>    
                        <table class='tabelaPedidos'>
                            <thead class='black white-text'>
                              <tr>
                                <th scope='col'>Status</th>
                                <th scope='col'>Track type</th>                            
                                <th scope='col'>Track type</th>                            
                                <th scope='col'>CreateTime</th>
                                <th scope='col'>TrackStatus </th>
                                <th scope='col'>StoreName </th>
                                <th scope='col'>CourierName</th>
                                <th scope='col'>Rating</th>
                                <th scope='col'>ReverseCode</th>
                                <th scope='col'>ReverseTime</th>     
                              </tr>
                            </thead>
                            
                            <tbody class='table table-striped' >
                              ".
                                $arrayPedidoDados
                              ."
                            </tbody>
                        </table>
                    </div>
        <!--  Dados do Produto -->";


              echo $tablePedidos;
              
            }     
    }

// {"Status":"1",
// "Result":{"TrackNo":"20181123101231620889",
// "TrackType":"Shopping online",
// "CreateTime":"1542939151",
// "TrackStatus":"Running",
// "StoreName":"Name11",
// "CourierName":"DHL",
// "Rating":"",
// "ReverseCode":"",
// "ReverseTime":"",
// "Operation":[
//   {"Type":"Pickup",
//               "Status":"Picked up",
//               "Terminal":"Test-Terminal-2222",
//               "Door":"2",
//               "DropoffUser":"Huangjiaqi",
//               "DropoffTime":"1542939206",
//               "PickupUser":"15961542300",
//               "PickupTime":"1542939366",
//               "Pay":"0.00",
//               "PickupPIN":"524794"},
//   {"Type":"Pickup",
//               "Status":"Droped off",
//               "Terminal":"Test-Terminal-2222",
//               "Door":"2",
//               "DropoffUser":"Huangjiaqi",
//               "DropoffTime":"1542953170",
//               "PickupUser":"",
//               "PickupTime":"",
//               "Pay":"",
//               "PickupPIN":"420893"},
//   {"Type":"Pickup",
//               "Status":"Droped off",
//               "Terminal":"Test-Terminal-2222",
//               "Door":"2",
//               "DropoffUser":"Huangjiaqi",
//               "DropoffTime":"1542953197",
//               "PickupUser":"",
//               "PickupTime":"",
//               "Pay":"","PickupPIN":"611647"}]}}


    public function estruturaDadosPedido($arrayDadosPedido){



        return true;
    }


    //function responsavel por formatar as estruturas de arrays que vem no formato stdClass
    public function recolheJason($retorno){
     
            $stdClass = json_decode(json_encode($retorno));
            $stdClass = json_decode($stdClass, true);
            
            return $tab = $stdClass;
    }


    public function listarTerminais(){

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $this->storeUrl,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => false,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS =>"{\"Application\":3007,\"ApiKey\":\"".$this->apiKey."\",\"Param\":{\"id\":null}}",
                  CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                  ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                   
                $response;

                return $convertArray = $this->recolheJason($response);

                        
                } 
    }

    //retorna o dia da semana
    public function diaSemana(){
          // Array com os dias da semana
          $diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

          $data = date('Y-m-d');

          // recebe o dia da semana
          $diasemana_numero = date('w', strtotime($data));

          // Exibe o dia da semana com o Array
          echo $diasemana[$diasemana_numero];
    }

    //ProtoTipo de verificação de data, 
    //a ideia seria implantar um verificador de intervalos entre uma hora e outra
    public function horaAgora(){
     $horaAgora =  date('h:s');

     $teste  = "08:30 - 19:00";
     $teste = explode('-',$teste);

     $teste1 = trim($teste[0]);
     $teste2 = trim($teste[1]);

     if( $horaAgora <= $teste1 && $horaAgora <= $teste2 ){
          echo "ok";
     }else{
          echo "ok!";
     }

     // var_dump($teste);

    }

    public function tabelaLocais(){
            $this->load->view('layouts/mainLayout');
            // instanciando a tabela requisitada na API
            $dadosLocais =  $this->listarTerminais();
            $count = 1;
            $data['tabela_locais'] = "";

            foreach ($dadosLocais['Result'] as $key => $row) {
                  
                    $data['tabela_locais'] .= "<tr>
                            <td>".$row['id']."</td>
                            <td>".$row['code']."</td>
                            <td class='btn'><button id='buscar' class='buscar'>".$row['name']."</button><input type='hidden' value='".base64_encode($row['id'])."'/></td>
                            <td>".$row['usable']."</td>
                            <td>".$row['boxnum']."</td>
                            <td>".$row['hotline']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['address_type']."</td>
                            <td>".$row['address']."</td>
                            <td>".$row['number']."</td>
                            <td>".$row['complement']."</td>
                            <td>".$row['district']."</td>
                            <td>".$row['city']."</td>
                            <td>".$row['state']."</td>
                            <td>".$row['zip']."</td>
                            <td>".$row['latitude']."</td>
                            <td>".$row['longitude']."</td>
                            <td>".$row['weektime']."</td>
                            <td>".$row['weekendtime']."</td>
                            <td>".$row['opdays']."</td>
                            <td>".$row['thumb']."</td>
                            <td>".$row['photo']."</td>
                            <td>".$row['province']."</td>
                          </tr>";


                          //# estrutura os dados e cordenadas dos marcadores
                          $array_locais[] = array(
                               "Distrito: ".$row['district']."<br> 
                               Endereço: ".$row['address_type']." ".$row['address'].", nº ".$row['number']."
                               CEP:".$row['zip'] , $row['latitude'], $row['longitude'],$count,

                          );
                          ++$count;
                    }
                  //encaminhando para a view      
                  $data['cordenadas'] = $array_locais;

                  $this->load->view('layouts/header');
                  $this->load->view('pontos/pontos',$data);
                   

    }  


    public function gerarTabela($data){
       
         echo $this->table->generate($data);
    }

}