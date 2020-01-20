<?php
namespace Myfx\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Myfx\Entity\ConfigurationMyfx;
use Zend\Http\Client;
use Zend\Http\Request;

class ConfigurationMyfxController extends CrudController{
    public function __construct() {
        $this->title = "Configurações Myfx";
        $this->table = 'ConfigurationMyfx';
        $this->entity = 'Myfx\Entity\\'.$this->table ;
        $this->service = 'Myfx\Service\\'.$this->table ;
        $this->form = 'Myfx\Form\\'.$this->table ;
        $this->controller = "ConfigurationMyfx";
        $this->route = 'configuration-myfx/defaults';

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-cogs',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => true,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit'
                    ),
                    'delete' => array(
                        'enable' => true,
                        'class' => 'btn btn-danger decision',
                        'icon' => 'fa fa-trash'
                    ),
                    'view' => array(
                        'enable' => false,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-eye'
                    ),
                ),
            ),
            'fields' => array(
                'id'=>array(
                    'label' => 'Id',
                    'list' => true,
                ),
                'title'=>array(
                    'label' => 'Título',
                    'list' => true,
                ),
                'key_value'=>array(
                    'label' => 'Valor Chave',
                    'list' => true,
                ),
                'value'=>array(
                    'label' => 'Valor',
                    'list' => true,
                ),
            ),
        );
    }

    public function siginAction() {
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();

        $value = '{"username":"' . $data['user']['username'] . '","password":"' . $data['user']['password'] . '"}';
        /**
         * @var ConfigurationMyfx $db_config
         */
        $db_config = $this->getEm()->getRepository('Myfx\Entity\ConfigurationMyfx')->findOneByValue($value);

        //FAZER O TESTE SE A SESSION ESTÁ FUNCIONANDO SENÃO RENOVE
        if($db_config){
            if($db_config->getSession() != ''){
                $uri = "https://www.myfxbook.com/api/get-my-accounts.json?session=" . $db_config->getSession();
                $response = $this->postService($uri);
                if(!$response->error){
                    $result = array(
                        'id'    => $db_config->getId(),
                        'error' =>  false,
                        'message' => '',
                        'session' => $db_config->getSession()
                    );

                    $_SESSION['myfx_user'] = $data['user'];

                    echo json_encode($result);
                    die;
                }
            }
        }

        $uri = "https://www.myfxbook.com/api/login.json?email=" . $data['user']['username'] . "&password=" . $data['user']['password'];

        $response = $this->postService($uri);

        $result = array(
            'id'        => null,
            'error'     => $response->error,
            'message'   => $response->message,
            'session'   => $response->session
        );

        if($response->error){
            echo json_encode($result);
            die;
        }else{
            if(!$db_config){
                $db_user = $this->getEm()->getRepository('Admin\Entity\User')->findOneById($this->getLogin());
                $db_config = new ConfigurationMyfx();
                $db_config->setTitle('Login Myfx');
                $db_config->setKeyValue('LOGIN');
                $db_config->setUser($db_user);
                $db_config->setValue($value);
            }

            $db_config->setSession($result['session']);

            $this->getEm()->persist($db_config);
            $this->getEm()->flush();

            $result['id'] = $db_config->getId();
            $_SESSION['myfx_user'] = $data['user'];
            echo json_encode($result);
            die;
        }
    }

    public function getAccountsAction()
    {
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $uri = "https://www.myfxbook.com/api/get-my-accounts.json?session=" . $data['session'];
        $response = $this->postService($uri);
        echo json_encode($response);
        die;
    }

    public function postService($uri){

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri($uri);
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
