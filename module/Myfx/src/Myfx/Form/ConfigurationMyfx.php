<?php
namespace Myfx\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class ConfigurationMyfx extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('configuration-myfx', $objectManager);
        $this->setInputFilter(new ConfigurationFilter());
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Text("title");
        $field->setLabel("Título: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("key_value");
        $field->setLabel("Valor Chave: *")
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $this->add(array(
            'name' => 'user',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Admin\Entity\User',
                'property' => 'nome',
                'display_empty_item' => true,
                'empty_item_label' => 'Mostrar para Todos',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('id' => 'ASC'),
                    )
                ),
                'label' => 'Usuário',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $field = new \Zend\Form\Element\Textarea("value");
        $field->setLabel("Valor: *")
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
