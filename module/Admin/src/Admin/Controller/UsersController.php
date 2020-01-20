<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Entity\User;
use Zend\Stdlib\Hydrator;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Mail\Storage;

use Zend\Paginator\Paginator,
    Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator,
    DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Zend\Paginator\Adapter\ArrayAdapter;
use Admin\Entity\UserPerfil;

class UsersController extends CrudController
{
    public function __construct(){
        $this->entity = 'Admin\Entity\User';
        $this->form = 'Admin\Form\User';
        $this->service = 'Admin\Service\User';
        $this->controller = 'Users';
        $this->route = 'admin';
    }
    
    public function newAction(){
       
        $form = new $this->form();
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0)){
            $array = $entity->toArray();
            unset($array['password']);
            $form->setData($array);
        
        }
        
        if($request->isPost()){
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());
            if($form->isValid()){
                //Se est�o certos eu insiro no banco de dados, mas para isso vou precisar de um service
                //
                /**
                 * @var \Admin\Service\User $service
                 */
                $service = $this->getServiceLocator()->get($this->service);
                $retorno = $service->insert($request->getPost()->toArray());                            

                
                if($retorno){
                    $this->flashmessenger()->addSuccessMessage('Seu Cadastro foi Realizado com Sucesso, Clique no Link que Recebeu em seu Email para Confirmar!');
                    //Mandando redirecionar o cara
                    return $this->redirect()->toRoute($this->route.'/defaults',array('controller'=>$this->controller));
                }else{
                    $this->flashmessenger()->addErrorMessage('O e-mail '.$request->getPost()->toArray()['email'].' ou o nome '.$request->getPost()->toArray()['nome'].' já está sendo utilizado!');
                    return $this->redirect()->toRoute($this->route.'/defaults',array('controller'=>$this->controller));
                }
            }
        }       
        
        $em = $this->em;
        
        $users = $em->getRepository('Admin\Entity\User')->findAllWithWhere();

        $cidades = $em->getRepository('Admin\Entity\City')->findAll();
        $estados = $em->getRepository('Admin\Entity\State')->findAll();
        
        return new ViewModel(array('form'=>$form,'users'=>$users,'cidades'=>$cidades,'estados'=>$estados));
    }
    
    public function editAction(){
        /**
         * @var User $entity
         */
        $hydrator = new Hydrator\ArraySerializable();
        $form = new $this->form();
        $request = $this->getRequest();
    
        $repository = $this->getEm()->getRepository($this->entity);
        
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0)){
           
            $array = $hydrator->extract($entity);
            unset($array['password']);
            $form->setData($array);
              
        }
              
        if($request->isPost()){
            /**
             * @var User $user
             */
            $data = $request->getPost()->toArray();
            $user = $this->em->getRepository('Admin\Entity\User')->findOneById($data['id']);

//            var_dump($data);
//            die;
            /** Verifica se existe alguem com o mesmo nome **/
            /** TODA VEZ QUE ALTERAR O NOME ALTERAR AS INDICAÇÕES **/
            if($user->getNome() != $data['nome']){
                $tem_mesmo_nome = $this->em->getRepository('Admin\Entity\User')->findByNome($data['nome']);

                if(!empty($tem_mesmo_nome)){
                    $this->flashmessenger()
                        ->addErrorMessage('O nome '.$data['nome'].' já consta no sistema, escolha outro!');
                    return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
                }

                $db_indicados = $this->em->getRepository('Admin\Entity\User')->findByIndicadoPor($user->getNome());

                if(!empty($db_indicados)){
                    foreach($db_indicados as $db_indicado){
                        $db_indicado->setIndicadoPor($data['nome']);

                        $this->em->persist($db_indicado);
                    }
                    $this->em->flush();
                }

            }
            
            //Setando todos os dados no formulario para dizer se os dados s�o validos ou n�o.
            $form->setData($request->getPost());

            $extension = explode('.',$_FILES['imagem']['name']);
            
            $uploaddir = 'public/img/clientes/';
            $docDestinoName = "cliente_".$data['id'].".".$extension[count($extension)-1];
            $destino = $uploaddir . $docDestinoName ;
            $origem = $_FILES['imagem']['tmp_name'];

            $enviouImagem = $this->smartCopy($origem, $destino);

            if($enviouImagem){
                $user->setImagem($docDestinoName);
            }

            $uploaddir = 'public/arquivos/documentos/';
            $docDestinoName = "documento_".$data['id']."_".basename($_FILES['documento']['name']);
            $destino = $uploaddir . $docDestinoName ;
            $origem = $_FILES['documento']['tmp_name'];
            
            $enviouDocumento = $this->smartCopy($origem, $destino);
            
            if($enviouDocumento){               
                $user->setDocumento($docDestinoName);
            }
            
            $uploaddir = 'public/arquivos/comprovantes/';
            $compDestinoName = "comprovante_".$data['id']."_".basename($_FILES['comprovante']['name']);
            $destino = $uploaddir . $compDestinoName;
            $origem = $_FILES['comprovante']['tmp_name'];
            
            $enviouComprovante = $this->smartCopy($origem, $destino); 
            
            if($enviouComprovante){                
                $user->setComprovante($compDestinoName);
            }
            
            $this->em->persist($user);
            $this->em->flush();

            /**
             * @var \Admin\Service\User $service
             */
            $service = $this->getServiceLocator()->get($this->service);

            $retorno = $service->update($request->getPost()->toArray());

            if($retorno){

                $this->flashmessenger()->addSuccessMessage('Usuário editado com sucesso!');
                //Mandando redirecionar o cara
                return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
            }else{
                $this->flashmessenger()->addErrorMessage('O e-mail '.$request->getPost()->toArray()['email'].' já está sendo utilizado!');
                return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
            }
            
        }       
        
        $em = $this->em;
        
        $users = $em->getRepository('Admin\Entity\User')->findAll();
        $cidades = $em->getRepository('Admin\Entity\City')->findAll();
        $estados = $em->getRepository('Admin\Entity\State')->findAll();
        
        $array['city'] = ($array['city']);
        $array['state'] = ($array['state']);
        
        return new ViewModel(array('form'=>$form,'users'=>$users,'cidades'=>$cidades,'estados'=>$estados,'dados'=>$array,'userCurrent'=>$entity,'em' => $this->em));
    
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
    
    public function viewAction(){
        $id = $this->params()->fromRoute('id',0);
        $em = $this->getEm();
        
        $user = $em->getRepository('Admin\Entity\User')->findOneBy(array('id'=>$id));
        
        return new ViewModel(array('user' => $user));
    }
    
    public function indexAction(){
        /**
         * @var User $login
         */
        $login = $this->getLogin();
        
        $em = $this->getEm();
        $userPerfils = $em->getRepository('Admin\Entity\UserPerfil')->findByUser($login);
   
        foreach($userPerfils as $v){
            /**
             * @var UserPerfil $v
             */
            $perfis[] = $v->getPerfil();
        }
        
        #dados para permissoes
        $recurso = 'modulos';
        $item = 'user';
        
        $request = $this->getRequest();

        $orderBy = '';
        if(isset($_GET['field']) && isset($_GET['orderby']))
            $orderBy = 'ORDER BY u.'.$_GET['field'].' '.$_GET['orderby'].' ';


        $user_login = $em->getRepository('Admin\Entity\User')->findOneById($login);
        $userPerfis = $user_login->getUserPerfis()->getValues();
        $afiliado = false;
        if(!empty($userPerfis)){
            foreach($userPerfis as $userPerfil){
                $db_perfil = $userPerfil->getPerfil();
                if(strtolower($db_perfil->getNome()) == 'afiliado'){
                    $afiliado = true;
                }
            }
        }

        if($request->isPost()){

            $post = $request->getPost()->toArray();
            $emptyFilter = 1;
            foreach ($post as $k=>$v){
                if($k != 'filter' && $v!=''){
                    #pode ter outros tipos de filtros: date,exactly
                    if($v !=''){
                        $filter['like'][$k] = $v;
                        $emptyFilter = 0;
                       
                    }
                }
            }
            
            if(isset($post['filter']) && $emptyFilter < 1){
                $repository = $this->em->getRepository($this->entity)->findFilter($filter);
                
                if(empty($repository)){
                    /**
                     * @var FlashMessenger $message
                     */
                    $this->flashmessenger()->addMessage("Não há registros encontrados");
             
                }
            }else{

                $acao = 'listAll';

                $hasPermission = $login->hasPermission($recurso,$item,$acao,$perfis);
                if($hasPermission){
                    if($afiliado){
                        $repository = $em->getRepository($this->entity)->findByIndicadoPor($user_login->getNome());
                        $repository[] = $em->getRepository($this->entity)->findOneById($user_login);
                    }else{
                        $repository = $em->getRepository($this->entity)->findAllWithWhere();
                    }
                }else{

                    $repository = $this->getEm()->getRepository($this->entity)->findById($login->getId());
                }
            }
        }else{

            $acao = 'listAll';
            $hasPermission = $login->hasPermission($recurso,$item,$acao,$perfis);
            if($hasPermission){
                if($afiliado){
                    $repository = $em->getRepository($this->entity)->findByIndicadoPor($user_login->getNome());
                    $repository[] = $em->getRepository($this->entity)->findOneById($user_login);
                }else{
                    $repository = $em->getRepository($this->entity)->findAllWithWhere();
                }

            }else{
                $repository = $em->getRepository($this->entity)->findById($login->getId());
            }
        }

        $page = $this->params()->fromRoute('page');
      
        $paginator = new Paginator(new ArrayAdapter(($repository == null)?array():$repository));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage(20);

        $users = $em->getRepository('Admin\Entity\User')->findAll();

        return new ViewModel(array('data'=>$repository,'paginator' => $paginator,'page'=>$page,'login'=>$this->getLogin(),'users'=>$users,'perfis'=>$perfis,'em'=>$em));
    
    }
    
    public function activeAction(){
        /**
         * @var User $user
         */
        $user = $this->getEm()->getRepository('Admin\Entity\User')->findOneById($this->params()->fromRoute('id'));
        $activateKey = $user->getActiveKey();
      
        $userService = $this->getServiceLocator()->get('Admin\Service\User');
        //$result = $userService->activate($activateKey);
        $result = $userService->activate($activateKey);
        //Result quando tem o valor � um usuario
        if($result){
            $this->flashmessenger()->addSuccessMessage("Usuário ativado com sucesso!");
            return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
        
        }else{
            $this->flashmessenger()->addErrorMessage("Houve um erro na ativação do usuário");
            return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
        }
    }
    
    public function deactiveAction(){
        /**
         * @var User $user
         */
        $user = $this->getEm()->getRepository('Admin\Entity\User')->findOneById($this->params()->fromRoute('id'));
        $user->setActive(null);
        $this->em->persist($user);
        $this->em->flush();        
        
        $this->flashmessenger()->addMessage("Usuário foi desativado com sucesso!");
        return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
    
    }
    
    public function perfilAction(){
        /**
         * @var User $user
         */
        $em = $this->getEm();
        $user = $em->getRepository('Admin\Entity\User')->findOneById($this->params()->fromRoute('id'));
        $userPerfis = $em->getRepository('Admin\Entity\UserPerfil')->findBy(array('user'=>$user));
    
        if(isset($userPerfis))
        foreach($userPerfis as $userPerfil){
            /**
             * @var UserPerfil $userPerfil
             */
            $userperfis[] = $userPerfil->getPerfil();
        }
        
        
       
        $perfis = $em->getRepository('Admin\Entity\Perfil')->findAll();
        
        $request = $this->getRequest();             
        
        if($request->isPost()){
            
            #Retirar todas as permissões
            $permissoes = $this->em->getRepository('Admin\Entity\UserPerfil')->findBy(array('user'=>$user));
            foreach($permissoes as $permissao){
                $this->em->remove($permissao);
                $this->em->flush();
            }
            
            $post = $request->getPost()->toArray();     
            
            if(isset($post['perfis']))
            foreach($post['perfis'] as $perfilId){
                $perfil = $em->getRepository('Admin\Entity\Perfil')->findOneById($perfilId);
                
                /**
                 * @var UserPerfil $UserPerfil
                 */
                $UserPerfil = $this->em->getRepository('Admin\Entity\UserPerfil')->findOneBy(array('perfil'=>$perfil,'user'=>$user));
                
                if(empty($UserPerfil)){
                
                    $UserPerfil = new UserPerfil();
                    $UserPerfil->setPerfil($perfil);
                    $UserPerfil->setUser($user);
                
                    $this->em->persist($UserPerfil);
                    $this->em->flush();
                    
                }               
                
            }          
            
            $this->flashmessenger()->addSuccessMessage("Registro salvo com sucesso!");
            return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
        }
       
        return new ViewModel(array('user'=>$user,'perfis'=>$perfis,'userPerfis'=>$userperfis));
    
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

    public function inverteData($data){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data)));
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data)));
        }
    }
    
    public function exportXlsAction(){
        //http://blog.thiagobelem.net/criando-e-exportando-planilhas-do-excel-com-php
        $arquivo = 'usuarios.xls';
        $users = $this->getEm()->getRepository('Admin\Entity\User')->findByActive(1);
        if(!empty($users)){
            $html = '';
            $html .= '<table>';
            $html .= '<tr>';
            $html .= '<td><b>Nome</b></td>';
            $html .= '<td><b>Email</b></td>';
            $html .= '<td><b>Situa&ccedil;&atilde;o</b></td>';
            $html .= '</tr>';
            foreach($users as $user){
                /**
                 * @var User $user
                 */
                $ativo = ($user->getActive())?'Ativo':'Inativo';
                $html .= '<tr>';
                $html .= '<td>'.$user->getNome().'</td>';
                $html .= '<td>'.$user->getEmail().'</td>';
                $html .= '<td>'.$ativo.'</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            header ("Content-type: application/x-msexcel");
            header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
            header ("Content-Description: PHP Generated Data" );
            echo $html;
        }
        die;

        $this->flashMessenger()->addSuccessMessage('E-mails exportados com sucesso');
        return $this->redirect()->toRoute('admin/defaults',array('controller'=>'users'));
    }
}

?>
