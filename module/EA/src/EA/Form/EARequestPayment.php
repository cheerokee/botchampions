<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EARequestPayment extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea-request-payment', $objectManager);

        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $this->add(array(
            'name' => 'ea_contract',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'EA\Entity\EAContract',
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
                'label' => 'Contrato',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class'     => 'form-control',
                'required'  => 'required'
            )
        ));

        $this->add(array(
            'name' => 'ea_yield',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'EA\Entity\EAYield',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('mes' => 'DESC','ano' => 'DESC'),
                    )
                ),
                'label' => 'Rendimento',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class'     => 'form-control',
                'required'  => 'required',
            )
        ));

        $field = new \Zend\Form\Element\Text("value");
        $field->setLabel("Valor: *")
            ->setAttribute('class','form-control moeda')
            ->setAttribute('required','required')
            ->setAttribute('onkeypress',"mascara(this,moeda)");
        $this->add($field);

        $field = new \Zend\Form\Element\Select("paid_out");
        $field->setLabel("Pago?: ")
            ->setValueOptions(array(
                0 => 'Não',
                1 => 'Sim'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control')
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Date("date_payment");
        $field->setLabel('Data de Pagamento : ')
            ->setAttribute('type','date')
            ->setAttribute('placeholder','DD/MM/AAAA');
        $this->add($field);

        $field = new \Zend\Form\Element\Date("due_date");
        $field->setLabel('Data de Vencimento *: ')
            ->setAttribute('type','date')
            ->setAttribute('required','required')
            ->setAttribute('placeholder','DD/MM/AAAA');
        $this->add($field);

        $field = new \Zend\Form\Element\File("receipt");
        $field->setLabel('Comprovante: ')
            ->setAttribute('class','form-control')
            ->setAttribute('accept','.gif,.jpg,.jpeg,.png,.doc,.docx,.pdf')
            ->setAttribute('placeholder','Faça upload do comprovante de depósito');
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
