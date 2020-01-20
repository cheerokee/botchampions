<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EAConfiguration extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea-configuration', $objectManager);

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Text("title");
        $field->setLabel("Título: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("key_value");
        $field->setLabel("Chave: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("value");
        $field->setLabel("Valor: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("editable");
        $field->setLabel("Editável pelo Administrador: ")
            ->setValueOptions(array(
                0 => 'Não',
                1 => 'Sim'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
        'name' => 'submit',
        'type'=>'Zend\Form\Element\Submit',
        'attributes' => array(
        'value'=>'Salvar',
        'class' => 'btn-success'
        )
        ));
    }
}
