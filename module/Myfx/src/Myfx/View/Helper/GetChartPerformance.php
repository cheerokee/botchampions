<?php

namespace Myfx\View\Helper;

use Myfx\Entity\GraphPerformance;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Doctrine\ORM\EntityManager;

class GetChartPerformance extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    public function __invoke($account,$session) {

        $helperPluginManager = $this->getServiceLocator();
        // the second one gives access to... other things.
        $serviceManager = $helperPluginManager->getServiceLocator();
        $this->setEm($serviceManager->get('Doctrine\ORM\EntityManager'));

        /**
         * @var GraphPerformance $db_graph_performance
         */
        $db_graph_performance = $this->getEm()->getRepository('Myfx\Entity\GraphPerformance')->findOneByAccount($account);

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri('https://www.myfxbook.com/api/get-my-accounts.json?session=' . $session);
        $request->getHeaders()->addHeaderLine('Content-Type:  application/json');

        $config = array(
            "adapter" => 'Zend\Http\Client\Adapter\Curl',
            "sslverifypeer" => false
        );

        $client = new Client();
        $client->setRequest($request);
        $client->setOptions($config);
        $client->send();
        $response = json_decode($client->getResponse()->getBody(),true);

        if($response['error']){
            return false;
        }

        $idAccount = '';
        $data_account = null;
        if(!empty($response['accounts']))
        {
            foreach($response['accounts'] as $acc){
                if($acc['accountId'] == $account || $acc['id'] == $account){
                    $idAccount = $acc['id'];
                    $data_account = $acc;
                }
            }
        }

        $urlBase = 'https://widgets.myfxbook.com/api/get-custom-widget.png?';

        $width = '700';
        $height = '508';

        $params = [
            'session=' . $session,
            'id=' . $idAccount,
            'width=' . $width,
            'height=' . $height,
            'bart=1',
            'linet=0',
            'bgColor=000000',
            'gridColor=BDBDBD',
            'lineColor=00CB05',
            'barColor=FF8D0A',
            'fontColor=FFFFFF',
            'title=' . $db_graph_performance->getTitle(),
            'titles=20',
            'chartbgc=181e5e'
        ];

        $uri = $urlBase . implode('&',$params);

        $html = '<div class="row">';
        if($data_account != null){
            $html.= "
            <div class='col-md-4'>
                <table class='table table-striped'>
                    <tr>
                        <th>Informação</th>
                        <th>Valor</th>
                    </tr>                
            ";
            if(!empty($data_account)){
                foreach ($data_account as $k => $data) {
                    $label = '';
                    $value = 0;
                    switch ($k){
                        case 'id':
                            continue;
                            break;
                        case 'name':
                            $label = 'Nome da Conta';
                            $value = $data;
                            break;
                        case 'accountId':
                            $label = 'Nº da Conta';
                            $value = $data;
                            break;
                        case 'gain':
                            $label = '<span class="text-success">Total de Ganho</span>';
                            $value = '<span class="text-success"><strong>'.$this->formatPercent($data).'</strong></span>';
                            break;
                        case 'absGain':
                            $label = 'Retorno sobre o investimento';
                            $value = $this->formatPercent($data);
                            break;
                        case 'daily':
                            $label = 'Ganho Hoje';
                            $value = $this->formatPercent($data);
                            break;
                        case 'monthly':
                            $label = 'Ganho dessa semana';
                            $value = $this->formatPercent($data);
                            break;
                        case 'withdrawals':
                            $label = 'Retiradas';
                            $value = $this->formatMoney($data);
                            break;
                        case 'deposits':
                            $label = 'Total Depositado';
                            $value = $this->formatMoney($data);
                            break;
                        case 'interest':
                            continue;
                            break;
                        case 'profit':
                            $label = '<span class="text-success">Lucro Total</span>';
                            $value = '<span class="text-success"><strong>'.$this->formatMoney($data).'</strong></span>';
                            break;
                        case 'balance':
                            $label = 'Saldo';
                            $value = $this->formatMoney($data);
                            break;
                        case 'drawdown':
                            $label = 'Rebaixamento';
                            $value = $this->formatPercent($data);
                            break;
                        case 'equity':
                            $label = 'Capital Próprio';
                            $value = $this->formatMoney($data);
                            break;
                        case 'equityPercent':
                            $label = 'Capital Próprio Percentual';
                            $value = $this->formatPercent($data);
                            break;
                        default:
                            continue;
                    }

                    if($label == ''){
                        continue;
                    }

                    $html .= "<tr><td>$label</td><td>$value</td></tr>";
                }
            }

            $html .= "
                </table>
            </div>";
        }

        $html .= "
            <div class='col-md-8'>
                <center>
                    <iframe width='$width' height='$height' src='".$uri."' frameBorder='0' scrolling='no'></iframe>
                </center>
            </div>";

        $html .= '<div class="col-md-12"><hr /></div></div>';

        return $html;
    }

    public function formatPercent($value) {
        return number_format($value, 2, ',', '.') . ' %';
    }

    public function formatMoney($value) {
        return '$' . number_format($value, 2, ',', '.');
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}

?>
