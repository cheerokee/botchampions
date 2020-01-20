<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EA extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea', $objectManager);

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Text("name");
        $field->setLabel("Nome: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("type");
        $field->setLabel("Tipo de Serviço: ")
            ->setValueOptions(array(
                0 => 'Expert Advisor',
                1 => 'Espelhamento'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("active");
        $field->setLabel("Ativo: ")
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
