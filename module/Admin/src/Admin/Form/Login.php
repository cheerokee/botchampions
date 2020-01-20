<?php
namespace Admin\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function __construct($name = null, $options = array()){
        //Colocando parent para o nome do form ficar como user.
        parent::__construct('Login',$options);

        $this->setAttribute('methos','post');     
       
        $email = new \Zend\Form\Element\Text('email');
        $email->setLabel('Email: ')
            ->setAttribute('placeholder','Entre com o Email');
        $this->add($email);
        
        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel('Password: ')
            ->setAttribute('placeholder','Entre com a senha');
        $this->add($password);       
        
        $this->add(array(
            'name'=>'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' =>'Entrar',
                'class' => 'btn-success'
            )
        ));
        
    }
    
}

?>