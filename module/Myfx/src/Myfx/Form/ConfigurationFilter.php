<?php
namespace Myfx\Form;

use Zend\InputFilter\InputFilter;

class ConfigurationFilter extends InputFilter
{
    public function __construct(){

        $this->add(array(
            'name'=>'user',
            'required'=>false
        ));

        
    }
    
}

?>
