<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EAXMAccount extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea-xm-account', $objectManager);

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $this->add(array(
            'name' => 'user',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Admin\Entity\User',
                'property' => 'nome',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findByOrderDate',
                    'params' => array()
                ),
                'label' => 'Usuário',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'component' => 'autocomplete'
            )
        ));

        $field = new \Zend\Form\Element\Text("number");
        $field->setLabel("Número da Conta: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("password");
        $field->setLabel("Senha: *")
            ->setAttribute('type','password')
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("server");
        $field->setLabel("Servidor: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
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
