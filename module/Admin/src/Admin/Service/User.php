<?php
namespace Admin\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Admin\Mail\Mail;

use Admin\Entity\City;
use Admin\Entity\State;
use Admin\Entity\Perfil;
use Admin\Entity\UserPerfil;

class User extends AbstractService
{
    protected $transport;
    protected $view;

    public $em;
    protected $configurationMail;

    public function __construct(EntityManager $em, SmtpTransport $tranport, $view){
        parent::__construct($em);

        $this->entity = 'Admin\Entity\User';
        $this->transport = $tranport;
        $this->view = $view;
    }
    
    /**
     * @return the $configurationMail
     */
    public function getConfigurationMail()
    {
        return $this->configurationMail;
    }

    /**
     * @param field_type $configurationMail
     */
    public function setConfigurationMail($configurationMail)
    {
        $this->configurationMail = $configurationMail;
    }
    
    public function insert(array $data){   
        $data['indicadoPor'] = (isset($data['indicadoPor']))?$data['indicadoPor']:'';

        /**
         * @var User $entity
         * @var Perfil $perfil
         */       
        $entity = $this->em->getRepository('Admin\Entity\User')->findOneByEmail($data['email']);
        
        if(isset($entity))
            return false;
        
        $entity = $this->em->getRepository('Admin\Entity\User')->findOneByNome($data['nome']);
        
        if(isset($entity))
            return false;

        /**
         * @var \Admin\Entity\User $entity
         */
        $entity = parent::insert($data);

        if($data['adminForm']){
            $entity->setActive(true);
        }

        if(isset($data['cidade'])){
            $tmp = explode(" - ",$data['cidade']);
            $cidadeNome = $tmp[0];
            $siglaEstado = (isset($tmp[1]))?$tmp[1]:'';
            
            /**
             * @var State   $estado
             * @var City    $cidade
             */
            $cidade = $this->em->getRepository('Admin\Entity\City')->findOneByName($cidadeNome);
            if($siglaEstado!='')
                $estado = $this->em->getRepository('Admin\Entity\State')->findOneByUf($siglaEstado);
            
            $entity->setCity(isset($cidade)?$cidade->getName():$cidadeNome);
            $entity->setState((isset($estado))?$estado->getName():'');
        }
        
        if(isset($data['indicado'])){
            $entity->setIndicadoPor($data['indicado']);
        }        

        $this->em->persist($entity);
        $this->em->flush();

        $extension = explode('.',$_FILES['imagem']['name']);

        $uploaddir = 'public/img/clientes/';
        $docDestinoName = "cliente_".$entity->getId().".".$extension[count($extension)-1];
        $destino = $uploaddir . $docDestinoName ;
        $origem = $_FILES['imagem']['tmp_name'];

        $enviouImagem = $this->smartCopy($origem, $destino);

        if($enviouImagem){
            $entity->setImagem($docDestinoName);
        }

        $this->em->persist($entity);
        $this->em->flush();

        $perfil = $this->em->getRepository('Admin\Entity\Perfil')->findOneByNome('Usuário Comum');
        if(empty($perfil)){
            $perfil = new Perfil();
            $perfil->setNome('Usuário Comum');
            $information = array(
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
                        'layout' => array(
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
                        'userConta' => 'Contas',
                        'layout' => 'Configurações de Layout'
                    )
                )

            );
            $information = str_replace(array("\t"," ","\r","\n","\s"),"",json_encode($information));
           
            $perfil->setInformation($information);
        
            $this->em->persist($perfil);
            $this->em->flush();
        }        
        
        /**
         * @var UserPerfil $UserPerfil
         */
        $UserPerfil = $this->em->getRepository('Admin\Entity\UserPerfil')->findOneBy(array('perfil'=>$perfil,'user'=>$entity));
        
        if(empty($UserPerfil)){
            
            $UserPerfil = new UserPerfil();
            $UserPerfil->setPerfil($perfil);
            $UserPerfil->setUser($entity);
            
            $this->em->persist($UserPerfil);
            $this->em->flush();
                        
        }
               
        if($entity){   

            if(empty($data['adminForm'])){

                $return = $this->sendConfirm($data);
            }

            if(isset($return) || $data['adminForm']){

                return $entity;
            }else{
                return false;
            }
        }
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
    
    public function activate($key){
        //Pegando o repository
        $repo = $this->em->getRepository('Admin\Entity\User');
        //Passando os criterios para achar, at� findOneBy � fixo depois � o nome do campo definido
        $user = $repo->findOneByActiveKey($key);
        //Verificando se est� ativo
        
        if($user && !$user->getActive()){
            //ATIVANDO
            $user->setActive(true);
            $this->em->persist($user);
            $this->em->flush();
            
            return $user;
        }
    }
    
    public function update(array $data){

        /**
         * @var User $entity
         */
        $emailOutraPessoa = $this->em->getRepository('Admin\Entity\User')->findOneByEmail($data['email']);
        $entity = $this->em->getReference($this->entity,$data['id']);
                
        //Se verdadeiro então esta tentando utilizar email de outra pessoa
        if(isset($emailOutraPessoa) && $entity->getEmail()!=$data['email'])
            return false;  
                    
        if(empty($data['password']))
            unset($data['password']);
        
        (new Hydrator\ClassMethods())->hydrate($data,$entity);
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
            
    }

    public function contato(array $data){
        $dataEmail = array(
            'nome' => $data['nome'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'mensagem' => $data['mensagem'],
        );

        $subject = 'Envio de contato atraves do site';
        $return = $this->sendMail($dataEmail,$subject,'contato');
        return $return;
    }

    public function lostPassword(array $data){

        $db_user = $this->em->getRepository('Admin\Entity\User')->findOneByEmail($data['email']);

        if($db_user){
            $novaSenha = $this->geraSenha();

            $db_user->setPassword($novaSenha);

            $this->em->persist($db_user);
            $this->em->flush();

            $data = array(
                'from'  =>  array(
                    $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                        $this->getConfigurationMail()['mail']['connection_config']['name_from']
                ),
                'to'    =>  array(
                    $db_user->getEmail() => $db_user->getNome()
                ),
                'name' => $db_user->getNome(),
                'senha' => $novaSenha
            );

            $subject = 'Recuperacao de senha';
            $return = $this->sendMail($data,$subject,'mail-lostPassword');

            if($return['result']){
                $return['msg'] = "Sua senha foi recuperada com sucesso, por favor entre na sua caixa de entrada para obter sua nova senha!";
            }

            return $return;
        }else{
            return array(
                'result'    =>  false,
                'msg'       =>  "Usuário não encontrado"
            );
        }
    }
    
    public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        // Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        // Variáveis internas
        $retorno = '';
        $caracteres = '';
        // Agrupamos todos os caracteres que poderão ser utilizados
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        // Calculamos o total de caracteres possíveis
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
            // Concatenamos um dos caracteres na variável $retorno
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }
    
    public function getUser($id){
        return $this->em->getRepository('Admin\Entity\User')->findOneById($id);
    }
    
    /**
     *
     * @return EntityManager
     */
    public function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    
            return $this->em;
        }
    }

    public function sendConfirm($data){
        /**
         * @var \Admin\Entity\User $entity
         */
        $entity = $this->em->getRepository('Admin\Entity\User')->findOneByEmail($data['email']);

        if(isset($data['reference']) && $data['reference'] == 'register'){
            $data = array(
                'from'  =>  array(
                    $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                    $this->getConfigurationMail()['mail']['connection_config']['name_from']
                ),
                'to'    =>  array(
                    $entity->getEmail() => $entity->getNome()
                ),
                'id'   =>  $entity->getId(),
                'activeKey' =>  $entity->getActiveKey(),
                'name' => $entity->getNome(),
                'email' => $entity->getEmail()
            );

            $subject = 'Cadastro efetuado no sistema';
            $return = $this->sendMail($data,$subject,'add-user');
        }else{
            $return['result'] = true;
        }

        return $return;
    }

    public function sendMail($data,$subject, $template){
        $mail = new \Base\Mail\Mail($this->transport, $this->view,$template);
        $mail->setData($data)->prepare();
        $result = $mail->send($this,$subject);

        return $result;
    }
}




























?>
