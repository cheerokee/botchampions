<?php
namespace Myfx\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Myfx\Entity\ConfigurationMyfx;
use Myfx\Entity\GraphPerformance;

class GraphPerformanceController extends CrudController{
    public function __construct() {
        $this->title = "Gráfico de Desempenho";
        $this->table = 'GraphPerformance';
        $this->entity = 'Myfx\Entity\\'.$this->table ;
        $this->service = 'Myfx\Service\\'.$this->table ;
        $this->form = 'Myfx\Form\\'.$this->table ;
        $this->controller = "GraphPerformance";
        $this->route = 'graph-performance/defaults';

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-graph',
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
                'account'=>array(
                    'label' => 'Conta',
                    'list' => true,
                ),
                'activeStr'=>array(
                    'label' => 'Ativo',
                    'list' => true,
                ),
            ),
        );
    }

    public function saveAction() {
        $em = $this->getEm();
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();

        $account = $data['account'];

        /**
         * @var ConfigurationMyfx $db_configuration
         * @var GraphPerformance $db_graph
         */

        $db_configuration = $em->getRepository('Myfx\Entity\ConfigurationMyfx')->findOneById($data['configuration']);
        $db_graph = $em->getRepository('Myfx\Entity\GraphPerformance')->findOneBy(array(
            'account'   =>  $account['accountId'],
            'configuration' => $db_configuration
        ));

        if(!$db_graph){
            $db_graph = $em->getRepository('Myfx\Entity\GraphPerformance')->findOneBy(array(
                'account'   =>  $account['id'],
                'configuration' => $db_configuration
            ));
        }

        if(!$db_graph){
            $db_graph = new GraphPerformance();
        }

        $db_graph->setTitle($account['name']);
        $db_graph->setActive(1);
        $db_graph->setAccount($account['accountId']);
        $db_graph->setConfiguration($db_configuration);

        $em->persist($db_graph);
        $em->flush();

        echo json_encode(array('result' => true));
        die;
    }
}
