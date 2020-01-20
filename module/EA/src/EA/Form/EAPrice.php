<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EAPrice extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea-price', $objectManager);

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Select("first");
        $field->setLabel("Primeira Parcela?: ")
            ->setValueOptions(array(
                0 => 'Não',
                1 => 'Sim'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control')
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Text("title");
        $field->setLabel("Título: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("price");
        $field->setLabel("Preço: *")
            ->setAttribute('class','form-control moeda')
            ->setAttribute('onkeypress',"mascara(this,moeda)");
        $this->add($field);

        $field = new \Zend\Form\Element\Text("link_checkout");
        $field->setLabel("Link do Checkout: ")
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
            'name' => 'ea',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'EA\Entity\EA',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('id' => 'ASC'),
                    )
                ),
                'label' => 'Serviço Automatizado',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class'     => 'form-control',
                'required'  => 'required',
            )
        ));

        $field = new \Zend\Form\Element\Select("free");
        $field->setLabel("Grátis: ")
            ->setValueOptions(array(
                0 => 'Não',
                1 => 'Sim'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control')
            ->setValue(0);
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
