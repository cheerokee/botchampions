<?php

namespace Myfx\View\Helper;

use Zend\Http\Client;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

class GetSession extends AbstractHelper {

    public function __invoke($username,$password) {
        $response = $this->postService($username,$password);
        if($response['error']){
            return null;
        }

        return $response['session'];
    }

    public function postService($username,$password){

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri('https://www.myfxbook.com/api/login.json?email='. $username .'&password='. $password);
        $request->getHeaders()->addHeaderLine('Content-Type:  application/json');

        $config = array(
            "adapter" => 'Zend\Http\Client\Adapter\Curl',
            "sslverifypeer" => false
        );

        $client = new Client();
        $client->setRequest($request);
        $client->setOptions($config);
        $client->send();
        $response = $client->getResponse()->getBody();

        return json_decode($response,true);
    }
}

?>
