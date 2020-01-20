<?php
namespace Admin\Form;

use Zend\Form\Form;

class Perfil extends Form
{
    public function __construct($name = null, $options = array()){
        //Colocando parent para o nome do form ficar como user.
        parent::__construct('perfil',$options);
        
        //INCLUINDO VALIDA��ES NO FORMUL�RIO.
        $this->setInputFilter(new UserFilter());
        
        $this->setAttribute('methos','post');       
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);
                
        $nome = new \Zend\Form\Element\Text("nome");
        $nome->setLabel('Nome: ')
            ->setAttribute('placeholder','Entre com o nome do perfil');
        $this->add($nome);
      
              
        $this->add(array(
            'name'=>'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' =>'Salvar',
                'class' => 'btn-success'
            )
        ));
        
    }
    
}

?>