<?php

namespace Admin\Controller;

use Admin\Form\User as FormUser;
use Admin\Entity\User;
use Admin\Entity\UserPerfil;
use Admin\Entity\Perfil;

use Base\Controller\BaseFunctions;
use Configuration\Entity\Configuration;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Model\ViewModel;
use Zend\Math\Rand;

use Doctrine\ORM\EntityManager;

class IndexController extends AbstractActionController
{
    public $em;

    public function indexAction()
    {   
        $user = $this->getLogin();
        $em = $this->getEm();

        $dol_str = json_decode(file_get_contents("https://economia.awesomeapi.com.br/all/USD-BRL"),true);
        if($dol_str){
            $db_config = $em->getRepository('Configuration\Entity\Configuration')->findOneByChave('DOLLAR');

            if($db_config){
                $db_config->setValue($dol_str['USD']['low']);
            }else{
                $db_config = new Configuration();
                $db_config->setTitle('Cotação Dolar');
                $db_config->setChave('DOLLAR');
                $db_config->setValue($dol_str['USD']['low']);
            }

            $em->persist($db_config);
            $em->flush();
        }

        return new ViewModel(array('em'=>$em,'user'=>$user));
    }

    public function defaultAction(){
        return new ViewModel(array());
    }

    public function sumDateAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();
            $date_start = $data['dateStart'];
            $num = $data['num'];

            $date =  date('Y-m-d', strtotime("+". $num ." days",strtotime($date_start)));

            $result = json_encode(array('date' => $date));
            echo $result;
            die;
        }

        echo 'Suma de datas';
        die;
    }

    public function registerAction()
    {        
        /**
         * @var User $user;
         */
        $em = $this->getEm();
        $this->layout()->setTemplate('layout/iframe-template.phtml');
        $form = new FormUser;
        //Todos dados que receber do form ficara em $request
        $request = $this->getRequest();
        //Verificando se o methodo de envio foi de um formulario.
                
        if((empty($request->getPost()->toArray()['rapidRegister']) || $request->getPost()->toArray()['rapidRegister'] == '') && $request-> isPost()){
            
            if($request->isPost()){
                
                $data = $request->getPost()->toArray();

                /** reCaptcha! Google **/
                $drequest['response'] = $data['g-recaptcha-response'];
                $drequest['secret'] = '6Lc3VcIUAAAAAJXJCjF0a7_ssAVl_EnnFMGkzcbH';

                $response = $this->postService($drequest);

                if($response->success || $_SERVER['HTTP_HOST'] == 'evandroforex.dev.br') {
                    if(isset($data['matricula'])){

                        //Preenchendo os dados enviados via formulario no formulario caso algo de errado.
                        $form->setData($request->getPost());

                        //Verificando se esta tudo certo, os dados passam pelos validator
                        if(!$form->isValid()){

                            //Agora vamos precisando de um service
                            //O servi�o que foi registrado em Module.php vamos utilizar aqui. Service\User
                            //Quando executada a linha abaixo o zend ja resolve todos aquelas dependencias que est� no registro
                            $service = $this->getServiceLocator()->get('Admin\Service\User');
                            //Se receber um insert, essa fun��o insert retorna o entity

                            $result = $service->insert($request->getPost()->toArray());

                            if($result){

                                $this->flashmessenger()->addSuccessMessage('Você foi cadastrado com sucesso, entre no seu e-mail e ative o seu cadastro');
                                //$this->flashmessenger()->addSuccessMessage('Você foi cadastrado com sucesso');
                                $_SESSION['msg'] = "Você foi cadastrado com sucesso, entre no seu e-mail e ative o seu cadastro";
                            }else{
                                $this->flashmessenger()->addErrorMessage('O e-mail '.$request->getPost()->toArray()['email'].' ou o nome '.$request->getPost()->toArray()['nome'].' já está sendo utilizado, tente recuperar a senha ou tente cadastrar com nome ou e-mail diferente!');
                                $_SESSION['msg'] = 'O e-mail '.$request->getPost()->toArray()['email'].' ou o nome '.$request->getPost()->toArray()['nome'].' já está sendo utilizado, tente recuperar a senha ou tente cadastrar com nome ou e-mail diferente!';
                            }
                        }

                        return $this->redirect()->toRoute('sonuser-auth');

                    }else if(isset($data['contato'])){

                        $service = $this->getServiceLocator()->get('Admin\Service\User');
                        $result = $service->contato($data);

                        if($result){
                            $this->flashmessenger()->addSuccessMessage(
                                'Ative sua matricula através do e-mail que acabamos de enviar. Contato enviado com sucesso, em breve iremos entrar em contato com você!!!'
                            );

                        }else{
                            $this->flashmessenger()->addErrorMessage('Desculpe, houve algum erro no envio de contato, por favor tente entrar em contato via telefone ou tente novamente!');
                        }

                        return $this->redirect()->toRoute('register',array('controller'=>'index','action'=>'register'));
                    }
                }else{
                    $this->flashmessenger()->addErrorMessage('Desculpe, houve algum erro na verificação!');
                    return $this->redirect()->toRoute('register',array('controller'=>'index','action'=>'register'));
                }
            }
        }
        //Caso de errado, preciso recuperar as mensagens do flash message caso tenha alguma.
       
        $users = $em->getRepository('Admin\Entity\User')->findAll();   
        $cidades = $em->getRepository('Admin\Entity\City')->findAll();        
        $estados = $em->getRepository('Admin\Entity\State')->findAll();
       
        
        return new ViewModel(array('form'=>$form,'users'=>$users,'cidades'=>$cidades,'estados'=>$estados,'request'=>$request->getPost()->toArray(),'em'=>$em));
    }
    
    public function activateAction(){
        $this->layout()->setTemplate('layout/login-template.phtml');
        //
        $activateKey = $this->params()->fromRoute('key');
    
        $userService = $this->getServiceLocator()->get('Admin\Service\User');
        //$result = $userService->activate($activateKey);
        $result = $userService->activate($activateKey);
        //Result quando tem o valor � um usuario
        if($result){
            return new ViewModel(array('user'=>$result));
    
        }else{
            return new ViewModel();
        }
    }

    public function getLogin(){
        $session = (array) $_SESSION['Admin'];
        /**
         * @var User $user
         */
        foreach($session as $v){
            if(isset($v['storage']))
                $login = $v['storage'];
        }
         
        return $login;
    }

    public function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
    {
        $result=false;

        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=copy($source, $__dest);
            chmod($__dest,$options['filePermission']);

        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }

            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!="..")
                {
                    if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);

        } else {
            $result=false;
        }
        return $result;
    }

    public function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    
            return $this->em;
        }
    }

    public function moedaToFloat($moeda)
    {
        return str_replace(',','.',str_replace('.','',$moeda))*1;
    }

    public function postService($data){

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri('https://www.google.com/recaptcha/api/siteverify?secret='.$data['secret'].'&response='.$data['response']);
        $request->getHeaders()->addHeaderLine('Content-Type:  application/json');

        $config = array(
            "adapter" => 'Zend\Http\Client\Adapter\Curl',
            "sslverifypeer" => false
        );

        $client = new Client();
        $client->setRequest($request);
        $client->setOptions($config);
        $client->send();
        $response = $client->getResponse()->getBody();

        return json_decode($response);
    }

}
