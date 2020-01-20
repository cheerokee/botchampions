<?php
namespace Configuration\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;

use Zend\Mail\Transport\Smtp as SmtpTransport;

class Configuration extends AbstractService{

    protected $transport;
    protected $view;
    protected $configurationMail;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Configuration\Entity\Configuration';
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