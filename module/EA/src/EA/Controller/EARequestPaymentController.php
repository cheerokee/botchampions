<?php
namespace EA\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Doctrine\ORM\EntityManager;
use EA\Entity\EAContract;
use EA\Entity\EARequestPayment;
use EA\Entity\EAYield;
use Zend\View\Renderer\PhpRenderer;

class EARequestPaymentController extends CrudController{
    public function __construct() {
        $this->title        = "Faturas";
        $this->table        = 'EARequestPayment';
        $this->entity       = 'EA\Entity\\'.$this->table ;
        $this->service      = 'EA\Service\\'.$this->table ;
        $this->form         = 'EA\Form\\'.$this->table ;
        $this->controller   = "ea-request-payment";
        $this->route        = 'ea-request-payment/defaults';

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-money',
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
                'ea_contract'=>array(
                    'label' => 'Nº do Contrado',
                    'list' => true,
                ),
                'ea_yield'=>array(
                    'label' => 'Rendimento',
                    'list' => true,
                ),
                'value'=>array(
                    'label' => 'Valor',
                    'list' => true,
                ),
                'due_date'=>array(
                    'label' => 'Vencimento',
                    'list' => true,
                ),
                'paid_out'=>array(
                    'label' => 'Pago?',
                    'list' => true,
                )
            ),
            'filters' => array(
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

        /**
         * @var EARequestPayment[] $entity
         */
        $entity = $em->getRepository('EA\Entity\EARequestPayment')->findAll();

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
            $entity = $em->getRepository('EA\Entity\EARequestPayment')->findByFilter($_SESSION['filter-form']);

            $data = $request->getPost();
            $arr = $data->toArray();

            $data->fromArray(array_merge($arr,$_SESSION['filter-form']));
            $request->setPost($data);

            $_POST = $_SESSION['filter-form'];
        }

        $per_page = 50;
        return parent::indexAction($entity, $per_page);
    }

    public function yieldSaveAction() {
        /**
         * @var BaseFunctions $functions
         * @var EntityManager $em
         */
        $functions = new BaseFunctions();
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();

            /**
             * @var EAYield $db_ea_yield
             */
            if(isset($data['id']) && $data['id'] != ''){
                $db_ea_yield = $em->getRepository('EA\Entity\EAYield')->findOneById($data['id']);
            }else{
                $db_ea_yield = $em->getRepository('EA\Entity\EAYield')->findOneBy(array(
                    'mes' => $data['mes'],
                    'ano' => $data['ano']
                ));

                if(!$db_ea_yield){
                    $db_ea_yield = new EAYield();
                }
            }

            $db_ea_yield->setMes($data['mes']);
            $db_ea_yield->setAno($data['ano']);

            $em->persist($db_ea_yield);
            $em->flush();

            /**
             * @var EARequestPayment[] $db_ea_request_payments
             */
            $db_ea_request_payments = $em->getRepository('EA\Entity\EARequestPayment')->findBy(array(
                'ea_yield' => $db_ea_yield
            ));

            if(empty($db_ea_request_payments)){
                /**
                 * @var EAContract[] $db_ea_contracts
                 */
                $db_ea_contracts = $em->getRepository('EA\Entity\EAContract')->findByStatus(1);
                if(!empty($db_ea_contracts)){
                    foreach($db_ea_contracts as $db_ea_contract){
                        /**
                         * @var EARequestPayment $db_ea_request_payment
                         * @var \DateTime $vencimento
                         */
                        $db_ea_request_payment = new EARequestPayment();
                        $db_ea_request_payment->setEaContract($db_ea_contract);
                        $db_ea_request_payment->setEaYield($db_ea_yield);
                        $this->saveEaRequest($db_ea_contract,$db_ea_yield,$db_ea_request_payment);
                    }
                }
            }else{
                foreach($db_ea_request_payments as $db_ea_request_payment){
                    if($db_ea_request_payment->getPaidOut()) //Faturas pagas do mes atual pula
                        continue;

                    /**
                     * @var EARequestPayment $db_ea_request_payment
                     * @var \DateTime $vencimento
                     */
                    $db_ea_contract = $db_ea_request_payment->getEaContract();
                    $this->saveEaRequest($db_ea_contract,$db_ea_yield,$db_ea_request_payment);
                }
            }

            echo json_encode(array('result' => true));
        }
        die;
    }

    /**
     * @param EAContract $db_ea_contract
     * @param EAYield $db_ea_yield
     * @param EARequestPayment $db_ea_request_payment
     * @throws \Exception
     */
    public function saveEaRequest($db_ea_contract,$db_ea_yield,$db_ea_request_payment){
        $em = $this->getEm();
        $vencimento = $db_ea_contract->getDateFinish()->format('Y-m-d');
        $vencimento = date('Y-m-d', strtotime("+10 days",strtotime($vencimento))); // 10dias adicionais
        $vencimento = new \DateTime($vencimento);


        $db_ea_request_payment->setDueDate($vencimento);
        $db_ea_request_payment->setPaidOut(0);

        $db_ea_request_payment->setValue(0);

        $yield_ciclo = $db_ea_yield->getAno() + $db_ea_yield->getMes() / 100;

        $mes_contract = $db_ea_contract->getDateStart()->format('m') * 1;
        $ano_contract = $db_ea_contract->getDateStart()->format('Y') * 1;
        $contract_ciclo = $ano_contract + $mes_contract / 100;
        if($yield_ciclo >= $contract_ciclo){
            $em->persist($db_ea_request_payment);
            $em->flush();
        }
    }

    public function sendMailRequestPaymentAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            /**
             * @var \EA\Service\EARequestPayment $service
             */
            $service = $this->getServiceLocator()->get($this->service);
            $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('panel-ea',array('id'=>  $data['id']));
            $result = $service->sendMailRequestPayment($data,$rota);
            echo json_encode(array('result' => true));
        }
        die;
    }


}
