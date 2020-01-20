<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

use Admin\Entity\Perfil;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Storage\SessionStorage;
use Admin\Entity\User;

class PerfilController extends CrudController
{
    protected $em;
    public function __construct(){
        $this->entity = 'Admin\Entity\Perfil';
        $this->form = 'Admin\Form\Perfil';
        $this->service = 'Admin\Service\Perfil';
        $this->controller = 'perfil';
        $this->route = 'admin';        
    }
    
    public function newAction(){
       
        $form = new $this->form();
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0)){
            $array = $entity->toArray();            
            $form->setData($array);        
        }
   
        if($request->isPost()){
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());
                    
            //Se est�o certos eu insiro no banco de dados, mas para isso vou precisar de um service
            //
            /**
             * @var \Admin\Service\Perfil $service
             */
            $service = $this->getServiceLocator()->get($this->service);
            $retorno = $service->insert($request->getPost()->toArray());                            
            
            if($retorno){
                $this->flashmessenger()->addSuccessMessage('Registro salvo com sucesso!');
                //Mandando redirecionar o cara
                return $this->redirect()->toRoute($this->route.'/defaults',array('controller'=>$this->controller));
            }else{
                $this->flashmessenger()->addErrorMessage('Houve algum erro no cadastro');
                return $this->redirect()->toRoute($this->route.'/defaults',array('controller'=>$this->controller));
            }
            
        }       
        $perfis = $this->em->getRepository('Admin\Entity\Perfil')->findAll();
        return new ViewModel(array('form'=>$form,'perfis'=>$perfis));
    }
    
    /**
     * @return User $login
     */
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
    
    public function editAction(){
        /**
         * @var Perfil $entity
         */
        $hydrator = new Hydrator\ArraySerializable();
        $form = new $this->form();
        $request = $this->getRequest();

        $entity = $this->getEm()->getRepository($this->entity)->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0)){         
            
            $array = $hydrator->extract($entity); 
           
            $form->setData($array);              
        }
        
        if($request->isPost()){
          
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());
            
            /**
             * @var \Admin\Service\Perfil $service
             */
            $service = $this->getServiceLocator()->get($this->service);
            $retorno = $service->update($request->getPost()->toArray());                            
            
            if($retorno){
                $this->flashmessenger()->addSuccessMessage('Registro editado com sucesso!');
                //Mandando redirecionar o cara
                return $this->redirect()->toRoute('admin/defaults',array('controller'=>$this->controller));
            }else{
                $this->flashmessenger()->addErrorMessage('Houve algum erro no cadastro');
                return $this->redirect()->toRoute('admin/defaults',array('controller'=>$this->controller));
            }
            
        }            
        
     
        
        return new ViewModel(array('form'=>$form));
    
    }
    
    public function indexAction(){
        $login = $this->getLogin();
        $em = $this->getEm();
        $userPerfils = $em->getRepository('Admin\Entity\UserPerfil')->findByUser($login);
        
        foreach($userPerfils as $v){
            /**
             * @var UserPerfil $v
             */
            $perfis[] = $v->getPerfil();
        }
        
        $request = $this->getRequest();
        
        if($request->isPost()){
            $post = $request->getPost()->toArray();
            
            foreach ($post as $k=>$v){
                if($k != 'filter' && $v!=''){
                    #pode ter outros tipos de filtros: date,exactly
                    $filter['like'][$k] = $v;
                }
            }
            
            if(isset($post['filter'])){
                $repository = $em->getRepository($this->entity)->findFilter($filter);
              
                if(empty($repository)){
                    /**
                     * @var FlashMessenger $message
                     */
                    $this->flashmessenger()->addMessage("Não há registros encontrados");
             
                }
            }else{
                $repository = $this->getEm()->getRepository($this->entity)->findAll();
            }
        }else{
            $repository = $em->getRepository($this->entity)->findAll();
        }
       
        
        return new ViewModel(array('data'=>$repository,'login'=>$this->getLogin(),'perfis'=>$perfis));
    
    } 
    
    public function permissaoAction(){
        
        /**
         * @var Perfil $entity
         */
        $entity = $this->getEm()->getRepository('Admin\Entity\Perfil')->findOneById($this->params()->fromRoute('id',0));
        
        $privileges = $entity->getInformation();
        
        $request = $this->getRequest();
    
        if($request->isPost()){
            $post = $request->getPost()->toArray();
            
            $privileges = json_decode($privileges,true);
            
                         
            $this->savePrivileges($entity,$privileges,$post);
            
            $this->flashmessenger()->addSuccessMessage('Perfil atualizado com sucesso!');
            return $this->redirect()->toRoute('admin/defaults',array('controller'=>$this->controller));
        }
        
        if(empty($privileges)){
            $privileges = array(
                            'recursos'=> array(                                   
                                    'modulos' => array(
                                        'user' => array(
                                            'list'      => 1,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 1,
                                        ),
                                        'perfil' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                        'configuration' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                        'userConta' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 1,
                                            'edit'      => 1,
                                        ),
                                        'comissao' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                        'pay-comissao' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                        'layout' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                        'layout-option' => array(
                                            'list'      => 0,
                                            'listAll'   => 0,
                                            'delete'    => 0,
                                            'new'       => 0,
                                            'edit'      => 0,
                                        ),
                                    ),
                                    'label' => array(
                                        'user'   => 'Clientes',
                                        'perfil' => 'Perfil',
                                        'configuration' => 'Configurações',
                                        'pay-comissao' => 'Pagamento de Comissão',
                                        'layout' => 'Configuração de Layout',
                                        'layout-option' => 'Opções de Layout'
                                    )
                                )
                            );
            $privileges = json_encode($privileges);
            
            $entity->setInformation($privileges);
            
            $this->em->persist($entity);
            $this->em->flush();
        }
     
        return new ViewModel(array('entity'=>$entity));
    
    }

    /**
     * @param Perfil    $entity
     * @param array     $privileges
     * @param array     $post
     * @param array    $recurso
     */
    public function savePrivileges($entity,$privileges,$post){
        $recursos = array('modulos','cursos');
        $actions['modulos'] = array('list','listAll','delete','new','edit');
        $actions['cursos'] = array('list');
        
        $perfil = $this->em->getRepository('Admin\Entity\Perfil')->findOneById($entity);        
                
        foreach($recursos as $recurso){
            if(isset($privileges['recursos'][$recurso])){
                $tmp = $privileges['recursos'][$recurso];
            
                foreach ($tmp as $nomeModulo => $modulo){   
                    
                    foreach($actions[$recurso] as $action){
                        if(isset($post['privilege'][$nomeModulo][$action])){
                            $tmp[$nomeModulo][$action] = $post['privilege'][$nomeModulo][$action]*1;
                        }else{
                            $tmp[$nomeModulo][$action] = 0;
                        }
                    }
            
                }
            
                $privileges['recursos'][$recurso] = $tmp;
            }
        }
        
        $privileges = json_encode($privileges);
        
        $perfil->setInformation($privileges); 
        
        $this->em->persist($perfil);
        $this->em->flush();  
        
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
