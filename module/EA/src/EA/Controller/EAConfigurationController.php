<?php
namespace EA\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;

class EAConfigurationController extends CrudController{
    public function __construct() {
        $this->title        = "Configurações (EA)";
        $this->table        = 'EAConfiguration';
        $this->entity       = 'EA\Entity\\'.$this->table ;
        $this->service      = 'EA\Service\\'.$this->table ;
        $this->form         = 'EA\Form\\'.$this->table ;
        $this->controller   = "ea-configuration";
        $this->route        = 'ea-configuration/defaults';

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
                'title'=>array(
                    'label' => 'Título',
                    'list' => true,
                ),
                'keyValue'=>array(
                    'label' => 'Valor Chave',
                    'list' => true,
                ),
                'value'=>array(
                    'label' => 'Valor',
                    'list' => true,
                ),
                'editableStr'=>array(
                    'label' => 'Editável por Administrador',
                    'list' => true,
                )
            ),
        );
    }

    public function indexAction($entity = null, $per_page = 10)
    {
        return parent::indexAction($entity, $per_page); // TODO: Change the autogenerated stub
    }
}