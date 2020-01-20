<?php
namespace EA\Form;
use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class EAContract extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('ea-contract', $objectManager);
        $this->setInputFilter(new EAContractFilter());
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Hidden('step');
        $field->setValue(3);
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

        $this->add(array(
            'name' => 'ea_xm_account',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'EA\Entity\EAXMAccount',
                'property' => 'number',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Conta na Activtrades',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required'
            )
        ));

//        $this->add(array(
//            'name' => 'ea_xm_account',
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'options' => array(
//                'disable_inarray_validator' => true,
//                'object_manager' => $objectManager,
//                'target_class' => 'EA\Entity\EAXMAccount',
//                'property' => 'number',
//                'display_empty_item' => true,
//                'empty_item_label' => 'Selecione...',
//                'is_method' => true,
//                'find_method' => array(
//                    'name' => 'findBy',
//                    'params' => array(
//                        'criteria' => array(),
//                        'orderBy' => array('id' => 'ASC'),
//                    )
//                ),
//                'label' => 'Conta na Activtrades',
//                'column-size' => 'sm-4',
//                'label_attributes' => array('class' => 'col-sm-2 input-sm')
//            ),
//            'attributes' => array(
//                'class'     => 'form-control',
//                'required'  => 'required',
//                /*
//                 * Esse componente tem a função de obedecer a mudança de um determinado campo da tabela
//                 * A tabela pai (master field) deve ter relação com a tabela filho (Referenciado nesse campo atual)
//                 */
//                'component' => 'join-select',
//                /*
//                master_field = É o campo dessa mesma tabela que ao ser alterada muda esta
//                fk_table = É a tabela filha deve ser passado o nome da tabela do apigility
//                fk_field = É o campo da tabela filha que é ligada com a tabela pai
//                */
//                'component_params' => '{"master_field" : "user","fk_table" : "eaxm-account","fk_field" : "user","father_type":"input"}'
//            )
//        ));

        $field = new \Zend\Form\Element\Text("value_in_account");
        $field->setLabel("Valor na Conta: (Verifique na conta do cliente) *")
            ->setAttribute('class','form-control moeda')
            ->setAttribute('onkeypress',"mascara(this,moeda)");
        $this->add($field);

        $field = new \Zend\Form\Element\Select("status");
        $field->setLabel("Ativo: ")
            ->setValueOptions(array(
                0 => 'Pendente',
                1 => 'Ativo',
                2 => 'Cancelado'
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Date("date_start");
        $field->setLabel('Data de Início *: ')
            ->setAttribute('type','date')
            ->setAttribute('required','required')
            ->setAttribute('placeholder','DD/MM/AAAA');
        $this->add($field);

        $field = new \Zend\Form\Element\Date("date_finish");
        $field->setLabel('Data de Término: ')
            ->setAttribute('type','date')
            ->setAttribute('component','days-select')
            ->setAttribute('component_params','{"days" : "30,60,90,180,270"}')
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
