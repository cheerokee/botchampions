<?php

namespace EA\Form;

use Zend\InputFilter\InputFilter;

class EAContractFilter  extends InputFilter
{
    
    public function __construct() 
    {
        $this->add(array(
            'name'=>'date_start',
            'required'=>false,
            'valid'=>true,
            'dateStepNotStep'=>true,
        ));

        $this->add(array(
            'name'=>'date_finish',
            'required'=>false,
            'valid'=>true,
            'dateStepNotStep'=>true,
        ));

        $this->add(array(
            'name'=>'user',
            'required'=>false,
            'valid'=>true,
        ));

        $this->add(array(
            'name'=>'ea_xm_account',
            'required'=>false,
            'valid'=>true,
        ));
    }
    
}
