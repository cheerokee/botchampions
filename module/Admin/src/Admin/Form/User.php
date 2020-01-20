<?php
namespace Admin\Form;

use Zend\Form\Form;

class User extends Form
{
    public function __construct($name = null, $options = array()){
        //Colocando parent para o nome do form ficar como user.
        parent::__construct('user',$options);
        
        //INCLUINDO VALIDA��ES NO FORMUL�RIO.
        $this->setInputFilter(new UserFilter());
        
        $this->setAttribute('methos','post');       
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);
        
        $indicadopor = new \Zend\Form\Element\Text("indicadoPor");
        $indicadopor->setLabel('Indicado Por: ')
            ->setAttribute('placeholder','Escreva o nome da pessoa que o indicou');
        $this->add($indicadopor);

        $indicadopor = new \Zend\Form\Element\Text("indicadoPorFifa");
        $indicadopor->setLabel('Indicado Por (FIFA): ')
            ->setAttribute('placeholder','Escreva o nome da pessoa que o indicou para o fundo de investimento!');
        $this->add($indicadopor);
        
        $nome = new \Zend\Form\Element\Text("nome");
        $nome->setLabel('Nome: ')
            ->setAttribute('placeholder','Entre com o nome');
        $this->add($nome);
       
        $email = new \Zend\Form\Element\Text('email');
        $email->setLabel('Email: ')
            ->setAttribute('placeholder','Entre com o Email');
        $this->add($email);
        
        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel('Password: ')
            ->setAttribute('placeholder','Entre com a senha');
        $this->add($password);
        
        $confirmation = new \Zend\Form\Element\Password('confirmation');
        $confirmation->setLabel('Redigite: ')
            ->setAttribute('placeholder','Redigite a senha');
        $this->add($confirmation);
        
        //GARANTINDO QUE OS DADOS QUE EST�O VINDO SEJA DE UM HUMANO
        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);
        
        $telefone = new \Zend\Form\Element\Text("telefone");
        $telefone->setLabel('Telefone: ')
        ->setAttribute('placeholder','Insira seu telefone');
        $this->add($telefone);
        
        $whatsapp = new \Zend\Form\Element\Text("whatsapp");
        $whatsapp->setLabel('Whatsapp: ')
        ->setAttribute('placeholder','Insira seu Whatsapp');
        $this->add($whatsapp);
        
        $facebook = new \Zend\Form\Element\Text("facebook");
        $facebook->setLabel('Facebook: ')
        ->setAttribute('placeholder','Insira seu facebook');
        $this->add($facebook);
        
        $cep = new \Zend\Form\Element\Text("cep");
        $cep->setLabel('CEP: ')
        ->setAttribute('placeholder','Insira seu CEP');
        $this->add($cep);
        
        $endereco = new \Zend\Form\Element\Text("endereco");
        $endereco->setLabel('Endereço: ')
        ->setAttribute('placeholder','Insira seu endereço');
        $this->add($endereco);
        
        $numero = new \Zend\Form\Element\Text("numero");
        $numero->setLabel('Número: ')
        ->setAttribute('placeholder','Insira seu número');
        $this->add($numero);
        
        $complemento = new \Zend\Form\Element\Text("complemento");
        $complemento->setLabel('Complemento: ')
        ->setAttribute('placeholder','Insira um complemento');
        $this->add($complemento);
        
        $rg = new \Zend\Form\Element\Text("rg");
        $rg->setLabel('RG: ')
        ->setAttribute('placeholder','Insira o RG');
        $this->add($rg);
        
        $bairro = new \Zend\Form\Element\Text("bairro");
        $bairro->setLabel('Bairro: ')
        ->setAttribute('placeholder','Insira um bairro');
        $this->add($bairro);
        
        $city = new \Zend\Form\Element\Text("city");
        $city->setLabel('Cidade: ')
        ->setAttribute('placeholder','Insira uma cidade');
        $this->add($city);
        
        $state = new \Zend\Form\Element\Text("state");
        $state->setLabel('Estado: ')
        ->setAttribute('placeholder','Insira um Estado');
        $this->add($state);
        
        $comprovante = new \Zend\Form\Element\File("comprovante");
        $state->setLabel('Comprovante: ')
            ->setAttribute('accept','.gif,.jpg,.jpeg,.png,.doc,.docx,.pdf')
        ->setAttribute('placeholder','Envie seu comprovante no formato .jpg');
        $this->add($comprovante);
        
        $documento = new \Zend\Form\Element\File("documento");
        $state->setLabel('Documento: ')
            ->setAttribute('accept','.gif,.jpg,.jpeg,.png,.doc,.docx,.pdf')
        ->setAttribute('placeholder','Envie seu documento no formato .jpg');
        $this->add($documento);

        $imagem = new \Zend\Form\Element\File("imagem");
        $state->setLabel('Foto: ')
            ->setAttribute('accept','.gif,.jpg,.jpeg,.png')
            ->setAttribute('placeholder','Altere a foto do perfil');
        $this->add($imagem);
        
        $this->add(array(
            'name'=>'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' =>'Salvar',
                'class' => 'btn-success'
            )
        ));
        
    }
    
}

?>