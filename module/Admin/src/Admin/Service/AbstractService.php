<?php
namespace Admin\Service;
//PULO DO GATO
use Doctrine\ORM\EntityManager;
//Vai ajudar bastante na parte de preencher os dados.

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

abstract class AbstractService{
    /*
     * @var EntityManager
     */
    protected $em;
    //NOME DA ENTIDADE QUE VAMOS PRECISAR
    protected $entity;
    
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    //Quais metodos que teremos utilizando essa camada de servi�o b�sica?
    //Resp: insert, update e delete
    public function insert(array $data){
        if(is_array($data)){
            $hydrator = new DoctrineHydrator($this->em);
            $entity = $hydrator->hydrate($data, new $this->entity());
        } else {
            $entity = $data;
        }
        
        $this->em->persist($entity);
        $this->em->flush();
               
        return $entity;
    }
    
    public function update(array $data){
        //getReference basea esses dados em uma referencia sem precisar dar um find no banco de dados
        $entity = $this->em->getReference($this->entity, $data['id']);
        //Peguei o que eu precisava, agora � necessario pupular o registro com os dados que vieram
        //do array data. E para isso vamos usar o hidrator.
        //Populando o entity
        (new Hydrator\ClassMethods())->hydrate($data,$entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function delete($id){
        //getReference basea esses dados em uma referencia sem precisar dar um find no banco de dados
        $entity = $this->em->getReference($this->entity,$id);
        
        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }
}