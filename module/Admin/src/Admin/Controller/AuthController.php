<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

//AuthenticationService é o sistema que faz a autenticação de fato.
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use Admin\Form\Login as LoginForm;
use Admin\Entity\User;
use Admin\Entity\UserPerfil;
use Admin\Entity\Perfil;

class AuthController extends AbstractActionController
{
    protected $em;
    public function indexAction(){

        $form = new LoginForm;
        $request = $this->getRequest();
        $error = false;
        
        $this->layout()->setTemplate('layout/login-template.phtml');
      
        if($request->isPost()){

            $form->setData($request->getPost());
            
            if($form->isValid()){
                
                $data = $request->getPost()->toArray();              
                
                // Criando Storage para gravar sessão da autenticação
                $sessionStorage =       new SessionStorage("Admin");
                $sessionPermissions=    new SessionStorage("Permissions");

                $auth = new AuthenticationService();
                $auth->setStorage($sessionStorage);//Definindo o SessionStorage para a auth
                
                $authAdapter = $this->getServiceLocator()->get('Admin\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);                
                
                $result = $authAdapter->authenticate();
                
                if($result->isValid()){   
                    
                    /**
                     * @var User $user
                     * @var User $userService
                     */
                    $user = $result->getIdentity();

                    //$entity = $this->em->getRepository('Admin\Entity\User')->find($user['user']);
                    $user = $this->getServiceLocator()->get('Admin\Service\User')->getUser($user['user']->getId());
                    
                    $userPerfils = $this->getServiceLocator()->get('Admin\Service\Perfil')->getEm()->getRepository('Admin\Entity\UserPerfil')->findByUser($user->getId());
                    
                    foreach($userPerfils as $userPerfil){
                        /**
                         * @var UserPerfil $userPerfil
                         * @var Perfil $perfil
                         */
                        $perfil = $this->getServiceLocator()->get('Admin\Service\Perfil')->getEm()->getRepository('Admin\Entity\Perfil')->findOneById($userPerfil->getId());
                        
                        $perfis[] = $userPerfil->getPerfil()->getInformation();
                    }                         
                    $em = $this->getEm();
                    $sessionStorage->write($user,null);
                    $sessionPermissions->write($perfis,null);

                    return $this->redirect()->toRoute('home');
                }else{
                    $error = true;
                }
            }
        }
        
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage("Admin"));       
        
        return new ViewModel(array('form'=>$form,'error'=>$error,'login'=>$auth->getIdentity()));
        
    }
    
    public function lostpasswordAction(){
        
        $this->layout()->setTemplate('layout/login-template.phtml');
        
        $form = new LoginForm;
        $request = $this->getRequest();
        $error = false;
        
        if($request->isPost()){
        
            $form->setData($request->getPost());
        
            if($form->isValid()){
                $data = $request->getPost()->toArray();
                                
                $userService = $this->getServiceLocator()->get('Admin\Service\User');
                
                $user = new User();
                $result = $userService->lostPassword($data);

                if($result['result']){
                    $this->flashmessenger()->addSuccessMessage('Sua senha foi recuperada com sucesso, por favor entre na sua caixa de entrada para obter sua nova senha!');
                    return $this->redirect()->toRoute('sonuser-auth',array('controller'=>'Auth'));
                }else{
                    $this->flashmessenger()->addErrorMessage('Não foi possível recuperar sua senha, e-mail não encontrado!');
                    return $this->redirect()->toRoute('lostpassword');
                }
            }
        }
        
        return new ViewModel(array('form'=>$form,'error'=>$error));
    }
    
    public function logoutAction(){ 
        
        $this->layout()->setTemplate('layout/login-template.phtml');
        
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage("Admin"));
        $auth->clearIdentity();
        
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage("Permissions"));
        $auth->clearIdentity();
        
        unset($_SESSION['Permissions']);
        
        return new ViewModel(array());
    }
    
    /**
     *
     * @return EntityManager
     */
    protected function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

            return $this->em;
        }
    }
    
}

?>
