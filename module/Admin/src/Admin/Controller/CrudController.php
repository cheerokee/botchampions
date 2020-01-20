<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

abstract class CrudController extends AbstractActionController
{
    protected $em;
    protected $service;
    //para falar qual entidade estamos utilizando
    protected $entity;
    //para falar qual form estamos utilizando
    protected $form;
    protected $route;
    protected $controller;
    
    
    //Esse action serve para fazer a listagem
    public function indexAction(){
        //Trazendo todos os registros que forem encontrados.
        $list = $this->getEm()
                ->getRepository($this->entity)
                ->findAll();
        //Pegar o parametro page caso ele tenha
        $page = $this->params()->fromRoute('page');
        //Respons�vel pela pagina��o
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
        //Um registro por p�gina
            ->setDefaultItemCountPerPage(10);
        
        return new ViewModel(array('data' => $paginator, 'page'=>$page));
    }
    
    public function newAction(){
        $form = new $this->form();
        $request = $this->getRequest();
        if($request->isPost()){
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());
            if($form->isValid()){
                //Se est�o certos eu insiro no banco de dados, mas para isso vou precisar de um service
                        
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());
                //Mandando redirecionar o cara
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form)); 
    }
    
    public function editAction(){
        $form = new $this->form();
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->param()->fromRoute('id',0))
            $form->setData($entity->toArray());
        
        if($request->isPost()){
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());
            if($form->isValid()){
                //Se est�o certos eu insiro no banco de dados, mas para isso vou precisar de um service
                //
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                //Mandando redirecionar o cara
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
        
    }
    
    public function deleteAction(){
        $service=$this->getServiceLocator()->get($this->service);
        
        if($service->delete($this->params()->fromRoute('id',0)))
            return $this->redirect()->toRoute($this->route.'/defaults',array('controller'=>$this->controller));
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