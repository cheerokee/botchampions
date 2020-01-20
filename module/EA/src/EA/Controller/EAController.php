<?php
namespace EA\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;

class EAController extends CrudController{
    public function __construct() {
        $this->title        = "Serviços Automáticos";
        $this->table        = 'EA';
        $this->entity       = 'EA\Entity\\'.$this->table ;
        $this->service      = 'EA\Service\\'.$this->table ;
        $this->form         = 'EA\Form\\'.$this->table ;
        $this->controller   = "ea";
        $this->route        = 'ea/defaults';

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
                'name'=>array(
                    'label' => 'Nome',
                    'list' => true,
                ),
                'typeStr'=>array(
                    'label' => 'Tipo de Serviço',
                    'list' => true,
                ),
                'activeStr'=>array(
                    'label' => 'Ativo',
                    'list' => true,
                ),
            ),
        );
    }


}
