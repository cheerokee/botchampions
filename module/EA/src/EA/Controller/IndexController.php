<?php
namespace EA\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use EA\Entity\EAContract;
use EA\Service\EA;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class IndexController extends CrudController
{
    public function indexAction(){

        return new ViewModel(array());
    }

    public function panelEaAction(){

        return new ViewModel(array());
    }

    public function eaContractSaveAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            if(!isset($data['id']) && !((isset($data['termo']) && $data['termo'] == 'on'))){
                echo json_encode(array('result' => false,'message' => 'Você precisa assinar o termo!'));
                die;
            }

            $db_ea = $em->getRepository('EA\Entity\EA')->findOneById($data['ea_id']);
            $db_user = $em->getRepository('Admin\Entity\User')->findOneById($data['ea_contract_user']);

            $new = false;
            $renew = false;

            if(isset($data['id']) && $data['id'] != ''){
                $db_contract = $em->getRepository('EA\Entity\EAContract')->findOneById($data['id']);

                if(isset($data['renew'])){ // CASO NÃO SEJA UMA RENOVAÇÃO
                    $renew = true;
                }

            }else{
                $db_contract = new EAContract();
                $new = true;
            }

            if(isset($data['account'])){
                $account = str_replace('number:','',$data['account']);
                $db_account = $em->getRepository('EA\Entity\EAXMAccount')->findOneById($account);
            }

            if(isset($data['price'])){
                $price = str_replace('number:','',$data['price']);
                $db_price = $em->getRepository('EA\Entity\EAPrice')->findOneById($price);
            }

//            if(!$db_price){
//                echo json_encode(array(
//                    'result'    =>  false,
//                    'message'   =>  'É necessário selecionar uma preço!'
//                ));
//                die;
//            }

            $db_contract->setEa($db_ea);
            $db_contract->setUser($db_user);

            if($db_account)
            {
                $db_contract->setEaXmAccount($db_account);
            }

            //$db_contract->setEaPrice($db_price);

            if($db_contract->getStatus() != 1) {
                $db_contract->setStatus(0);
            }

            $db_contract->setStep(2);
            $db_contract->setPaymentMethod(0);
            $db_contract->setObservation($data['observation']);

            $em->persist($db_contract);
            $em->flush();

            /**
             * INICIO CADASTRO COMPROVANTE
             */
            if(isset($_FILES['ea_comprovante_file'])){
                $destino = 'public/arquivos/ea/comprovantes/';
                mkdir('public/'.$destino,0777);
                $extension = explode('.',$_FILES['ea_comprovante_file']['name']);
                $uploaddir = $destino;
                $docDestinoName = 'receipt'."_".$db_contract->getId().".".$extension[count($extension)-1];
                $destino = $uploaddir . $docDestinoName ;
                $origem = $_FILES['ea_comprovante_file']['tmp_name'];

                $result_receipt = $this->smartCopy($origem, $destino);
                if ($result_receipt) {
                    $db_contract->setReceipt($docDestinoName);
                    $em->persist($db_contract);
                }

                $em->flush();

                if(!$result_receipt){
                    echo json_encode(array(
                        'result' => false,
                        'message' => 'Houve um erro ao cadastrar o comprovante, contrato cancelado, entre em contato com o administrador!'
                    ));
                    die;
                }
            }
            /**
             * FIM CADASTRO COMPROVANTE
             * NOTIFICAÇÃO DE USUÁRIO
             * @var EA $service
             */
            $service = $this->getServiceLocator()->get("EA/Service/EA");
            $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('ea-contract/defaults',array('controller'=>'ea-contract','action'=>'edit','id'=>$db_contract->getId()));

            if($new || $renew){
                $result = $service->notificaComprovante($db_contract,$rota,$renew);
            }else{
                $result = true;
            }

            if(!$result){
                $this->em->remove($db_contract);
                echo json_encode(array(
                    'result' => false,
                    'message' => 'Houve erro ao notificar o administrador, por favor, entre em contato com o Administrador!'
                ));
                die;
            }
            /**
             * FIM NOTIFICAÇÃO
             */

            if($new){
                echo json_encode(array(
                    'result' => true,
                    'message' => 'Contrato cadastrado com sucesso!',
                    'contract_id' => $db_contract->getId()
                ));
            }else{
                echo json_encode(array('result' => true,'message' => 'Contrato atualizado com sucesso!','contract_id' => $db_contract->getId()));
            }
            die;
        }
    }

    public function requestPaymentAction() {
        return new ViewModel(array());
    }
}
