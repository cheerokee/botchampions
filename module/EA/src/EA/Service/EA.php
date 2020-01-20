<?php
namespace EA\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class EA extends AbstractService{

    protected $em,$transport,$view,$configurationMail;

    public function __construct(\Doctrine\ORM\EntityManager $em,SmtpTransport $tranport, $view) {
        parent::__construct($em);
        $this->transport = $tranport;
        $this->view = $view;
        $this->entity = 'EA\Entity\EA';
    }

    public function notificaComprovante($entity,$rota,$renew = false){

        $type_service = "";

        switch ($entity->getEa()->getType()){
            case 0:
                $type_service = "Expert Advisor";
                break;
            case 1:
                $type_service = "Espelhamento";
                break;
            default:
                $type_service = "Serviço automatizado";
        }

        /**
         * @var \EA\Entity\EAContract $entity
         */
        $data = array(
            'to'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                    $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'from'    =>  array(
                $entity->getUser()->getEmail() => $entity->getUser()->getNome()
            ),
            'nome'  => $entity->getUser()->getNome(),
            'type_service' => $type_service,
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
            'account_xm' => $entity->getEaXmAccount()->getNumber()
        );

        if($renew){
            $data['valor'] = $entity->getValueInAccountStr();
            $subject = $type_service . ': Solicitacao de Renovação';
            return $this->sendMail($data,$subject,'notify-ea-contract-renew');
        }else{
            $subject = $type_service . ': Solicitacao de Ativacao';
            return $this->sendMail($data,$subject,'notify-ea-contract');
        }
    }

    public function sendMail($data,$subject, $template){
        $mail = new \Base\Mail\Mail($this->transport, $this->view,$template);
        $mail->setData($data)->prepare();
        $result = $mail->send($this,$subject);

        return $result;
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
}


























?>
