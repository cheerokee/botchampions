<?php
namespace EA\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class EARequestPayment extends AbstractService{

    protected $em,$transport,$view,$configurationMail;

    public function __construct(\Doctrine\ORM\EntityManager $em,SmtpTransport $tranport, $view) {
        parent::__construct($em);
        $this->transport = $tranport;
        $this->view = $view;
        $this->entity = 'EA\Entity\EARequestPayment';
    }

    public function sendMailRequestPayment($data,$rota){
        $em = $this->em;
        /**
         * @var \EA\Entity\EARequestPayment $db_request_payment
         */
        $db_request_payment = null;
        if(isset($data['id']) && $data['id'] != ''){
            $db_request_payment = $em->getRepository('EA\Entity\EARequestPayment')->findOneById($data['id']);
        }

        if($db_request_payment){
            $user = $db_request_payment->getEaContract()->getUser();

            $cotacao = $em->getRepository('Configuration\Entity\Configuration')->findOneByChave('DOLLAR')->getValue();
            $data = array(
                'from'  =>  array(
                    $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                        $this->getConfigurationMail()['mail']['connection_config']['name_from']
                ),
                'to'    =>  array(
                    $user->getEmail() => $user->getNome()
                ),
                'nome'  => $user->getNome(),
                'conta'  => $db_request_payment->getEaContract()->getEaXmAccount()->getNumber(),
                'value' => number_format($db_request_payment->getValue() * $cotacao, 2, ',', '.'),
                'id'    => $db_request_payment->getId(),
                'email' => $user->getEmail(),
                'rota'  => $rota,
                'vencimento' => $db_request_payment->getDueDate()->format('d/m/Y')
            );

            $subject = "Fatura fechada disponível para pagamento";
            $mail = new \Base\Mail\Mail($this->transport, $this->view,'fatura');
            $mail->setData($data)->prepare();
            $result = $mail->send($this,$subject);
        }

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
