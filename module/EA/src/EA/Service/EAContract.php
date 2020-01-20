<?php
namespace EA\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class EAContract extends AbstractService{

    protected $em,$transport,$view,$configurationMail;

    public function __construct(\Doctrine\ORM\EntityManager $em,SmtpTransport $tranport, $view) {
        parent::__construct($em);
        $this->transport = $tranport;
        $this->view = $view;
        $this->entity = 'EA\Entity\EAContract';
    }

    public function notificaComprovante($entity,$rota){
        /**
         * @var \EA\Entity\EAContract $entity
         */
        $data = array(
            'nome'  => $entity->getUser()->getNome(),
            'valor' => number_format($entity->getEa()->getPrice(), 2, ',', '.'),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
        );

        $subject = 'Contratacao Expert Advisor / Espelhamento: Solicitacao de Ativacao';

        return $this->sendMailSelf($data,$subject,'notify-ea');
    }

    public function notificaRenovacao($entity,$rota,$renew = false){
        $operacao = ($renew)?'Renovação':'Ativação';
        /**
         * @var \EA\Entity\EAContract $entity
         */
        $data = array(
            'from'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'to'    =>  array(
                $entity->getUser()->getEmail() => $entity->getUser()->getNome()
            ),
            'nome'  => $entity->getUser()->getNome(),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
            'service_name' => $entity->getEa()->getName(),
            'service_type' => $entity->getEa()->getTypeStr(),
            'operacao' =>  $operacao,
            'conta' =>  $entity->getEaXmAccount()->getNumber()
        );

        if($renew){
            $subject = 'Renovacao Expert Advisor / Espelhamento: Renovacao realizada com sucesso';
        }else{
            $subject = 'Ativacao Expert Advisor / Espelhamento: Solicitacao de Ativacao';
        }
        return $this->sendMail($data,$subject,'notify-renovacao');
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
