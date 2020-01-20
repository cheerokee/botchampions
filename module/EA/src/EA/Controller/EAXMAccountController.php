<?php
namespace EA\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Zend\View\Renderer\PhpRenderer;

class EAXMAccountController extends CrudController{
    public function __construct() {
        $this->title        = "Conta XM";
        $this->table        = 'EAXMAccount';
        $this->entity       = 'EA\Entity\\'.$this->table ;
        $this->service      = 'EA\Service\\'.$this->table ;
        $this->form         = 'EA\Form\\'.$this->table ;
        $this->controller   = "ea-xm-account";
        $this->route        = 'ea-xm-account/defaults';

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-file-text',
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
                'numberCollumn'=>array(
                    'label' => 'Número da Conta',
                    'list' => true,
                ),
                'password'=>array(
                    'label' => 'Senha',
                    'list' => true,
                ),
                'server'=>array(
                    'label' => 'Servidor',
                    'list' => true,
                ),
                'user'=>array(
                    'label' => 'Usuário',
                    'list' => true,
                )
            ),
            'filters' => array(
                'user' => array(
                    'label'     => 'Usuário',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'ea' => array(
                    'label'     => 'Copy Trader',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'ea-xm-account' => array(
                    'label'     => 'Conta Activtrades',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                )
            )
        );
    }

    public function indexAction($entity = null, $per_page = 10)
    {
        $request = $this->getRequest();

        /**
         * @var EntityManager $em
         */
        $em = $this->getEm();

        $entity = $em->getRepository('EA\Entity\EAXMAccount')->findAll();

        if($request->isPost())
        {
            $data = $request->getPost()->toArray();

            if(isset($data['filter-form']) || isset($_SESSION['filter-form']))
            {
                $_SESSION['filter-form'] = $data;
            }
        }

        if(isset($_SESSION['filter-form']))
        {
            $entity = $em->getRepository('EA\Entity\EAXMAccount')->findByFilter($_SESSION['filter-form']);

            $data = $request->getPost();
            $arr = $data->toArray();

            $data->fromArray(array_merge($arr,$_SESSION['filter-form']));
            $request->setPost($data);

            $_POST = $_SESSION['filter-form'];
        }

        $per_page = 50;
        return parent::indexAction($entity, $per_page);
    }
}
