<?php
namespace Configuration\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Layout extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('layout', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $title = new \Zend\Form\Element\Text("title");
        $title->setLabel("Título: ")
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($title);

        $field = new \Zend\Form\Element\Select("active");
        $field->setLabel("Ativo: ")
            ->setValueOptions(array(
                '0' => 'Não',
                '1' => 'Sim'
            ))
            ->setAttribute('value','1')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
            'value'=> 'Salvar',
            'class' => 'btn-success'
            )
        ));
    }
}
