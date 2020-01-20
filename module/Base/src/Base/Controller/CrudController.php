<?php

namespace Base\Controller;

use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;
use Doctrine\ORM\EntityManager;

use Zend\Stdlib\Hydrator;

abstract class CrudController extends AbstractActionController
{
    
    protected $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;
    
    public function __construct(){
    }
    
    public function indexAction($entity = null,$per_page = 10) {

        if($entity !== null) {
            $list = $entity;
        }else{
            $list = $this->getEm()
                ->getRepository($this->entity)
                ->findAll();
        }

        $page = $this->params()->fromRoute('page');
        
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($per_page);

        $form = $this->getForm();

        $view = new ViewModel(
        array(
            'em' => $this->getEm(),
            'data'=>$paginator,
            'form'=>$form,
            'page'=>$page,
            '_listView' => $this->_listView,
            'route' => $this->route,
            'entity' => $entity
        ));

        if($this->_listView){
            $view->setTemplate('base/crud/index');
        }

        return $view;
    }
    
    /**
     * CrudController::getForm()
     * Obtendo a instância do form através do ServiceManager
     * Ou Intancia de forma normal o formulário, caso o mesmo
     * não tenha dependências
     *
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        $form = null;

        if ($this->getServiceLocator()->has($this->form)){
            $form = $this->getServiceLocator()->get($this->form);
        }else{
            $form = new $this->form();
        }

    
        if($this->validator){
            $form->setInputFilter(new $this->validator($this->getEm()));
        }

        $form->add(array(
            'name' => 'post-fieldset',
            'type' => 'Base\Form\Fieldset\SubmitCancel',
            'attributes' => array('class' => 'form-inline col-sm-offset-2'),
            'options' => array('column-size' => 'sm-10 col-sm-offset-2')
        ));

        return $form;
    }
    

    public function newAction($request = null)
    {
        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();
        $em = $this->getEm();
        $form = $this->getServiceLocator()->get($this->form);
        if($request == null){
            $request = $this->getRequest();
        }

        if($request->isPost())
        {
            $form->setData($request->getPost());

//            if($form->isValid())
//            {
                $data = $request->getPost()->toArray();

                foreach ($form as $element) {
                    $type = $element->getAttributes()['type'];
                    $class = $element->getAttributes()['class'];

                    if($type == 'date' || $type == 'datetime-local') {
                        if($data[$element->getName()] instanceof \DateTime){
                            $data[$element->getName()] = $data[$element->getName()];
                        }else{
                            $data[$element->getName()] = new \DateTime($data[$element->getName()]);
                        }
                    }

                    if(strpos($class,"moeda")){
                        $data[$element->getName()] = $functions->moedaToFloat($element->getValue());
                    }

                    if($element->getName() == 'name')
                    {
                        if(isset($data['friendlyUrl']))
                        {
                            $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($element->getValue());
                        }
                    }

                    if($element instanceof ObjectSelect){
                        $field = $element->getName();
                        $setObject = $element->getProxy()->getTargetClass();
                        if($data[$field] != ''){
                            if($data[$field] != null){
                                $db_obj = $em->getRepository($setObject)->findOneById($data[$field]);

                                if($db_obj)
                                {
                                    $data[$field] = $db_obj;
                                }
                            }
                        }else{
                            $data[$field] = null;
                        }

                    }
                }

                $service = $this->getServiceLocator()->get($this->service);
                
                $novo = $service->insert($data);

                if($novo){
                    $_SESSION['entity_id'] = $novo->getId();

                    if($request->getPost()->toArray()['success_message'] != null){
                        $this->flashMessenger()->addSuccessMessage($request->getPost()->toArray()['success_message']);
                    }else{
                        $this->flashMessenger()->addSuccessMessage("Registro criado com sucesso!");
                    }
                }else{
                    if($request->getPost()->toArray()['error_message'] != null){
                        $this->flashMessenger()->addErrorMessage($request->getPost()->toArray()['error_message']);
                    }else{
                        $this->flashMessenger()->addErrorMessage("Houve um erro na criação do registro!");
                    }
                }

                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            //}
        }

        $view = new ViewModel(array(
            'form' => $form,
            'controller' => $this->controller,
            'title'=> $this->title,
            'route' => $this->route,
            'em' => $this->getEm()
        ));
        
        $view->setTemplate('base/crud/new.phtml');
        
        return $view;
    }
    
    public function editAction($request = null){
        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();
        $em = $this->getEm();
        if($request == null){
            $request = $this->getRequest();
        }

        $form = $this->getServiceLocator()->get($this->form);
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));

        if($this->params()->fromRoute('id',0) && $entity != null)
            $form->setData((new Hydrator\ClassMethods())->extract($entity));

        if($request->isPost())
        {

            $form->setData($request->getPost());

            if($form->isValid())
            {

                $data = $request->getPost()->toArray();

                foreach ($form as $element) {
                    $type = $element->getAttributes()['type'];
                    $class = $element->getAttributes()['class'];

                    if($type == 'date' || $type == 'datetime-local') {
                        if($data[$element->getName()] instanceof \DateTime){
                            $data[$element->getName()] = $data[$element->getName()];
                        }else{
                            $data[$element->getName()] = new \DateTime($data[$element->getName()]);
                        }
                    }

                    if(strpos($class,"moeda")){
                        $data[$element->getName()] = $functions->moedaToFloat($element->getValue());
                    }

                    if($element->getName() == 'name')
                    {
                        if(isset($data['friendlyUrl']))
                        {
                            $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($element->getValue());
                        }
                    }

                    if($element instanceof ObjectSelect){
                        $field = $element->getName();
                        $setObject = $element->getProxy()->getTargetClass();
                        if($data[$field] != ''){
                            if($data[$field] != null){
                                $db_obj = $em->getRepository($setObject)->findOneById($data[$field]);

                                if($db_obj)
                                {
                                    $data[$field] = $db_obj;
                                }
                            }
                        }else{
                            $data[$field] = null;
                        }

                    }
                }

                $service = $this->getServiceLocator()->get($this->service);

                $alterado = $service->update($data);

                $this->flashMessenger()->addSuccessMessage("Registro alterado com sucesso!");
                
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller,'action'=>'index'));
            }
        }

        $view = new ViewModel(array(
            'form' => $form,
            'controller' => $this->controller,
            'title'=> $this->title,
            'route' => $this->route,
            'id' => $this->params()->fromRoute('id',0),
            'entity' => $entity,
            'em' => $this->getEm()
        ));
        
        $view->setTemplate('base/crud/edit.phtml');
        
        return $view;
    }
    
    public function deleteAction()
    {
        $service = $this->getServiceLocator()->get($this->service);
        if($service->delete($this->params()->fromRoute('id',0)))
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
    }

    public function clearFilterAction(){
        unset($_SESSION['filter-form']);
        return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
    }

    /**
     * retorna um entity manager
     *
     * @return Ambigous <object, multitype:, \Doctrine\ORM\EntityManager>
     */
    public function getEm($entityName = null)
    {
        if (null === $this->em){
            if($this->emName)
                $this->em = $this->getServiceLocator()->get($this->emName);
                else
                    $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
    
        if($entityName !== null)
            return $this->em->getRepository($entityName);
    
            return $this->em;
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
    
    /**
     * Retorna o serviço crud da entidade insert,update,delete
     * @param String $serviceName - Novo serviço
     * @return \Base\Service\AbstractService
     */
    public function getService($serviceName=null)
    {
        $service = $this->getServiceLocator()->get(($serviceName)?$serviceName:$this->service);
        return $service;
    }
    
    

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function paginator($list,$pageNumber,$count = 10)
    {
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setDefaultItemCountPerPage($count);
    
        return $paginator;
    }

    public function smartCopy($source, $dest, $options=array('folderPermission'=>0777,'filePermission'=>0777))
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
}
