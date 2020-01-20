<?php

namespace Myfx\View\Helper;

use Zend\Http\Client;
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

class TestSession extends AbstractHelper {

    public function __invoke($session) {
        $response = $this->postService($session);
        if($response['error']){
            return null;
        }

        return $session;
    }

    public function postService($session){

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri('https://www.myfxbook.com/api/get-my-accounts.json?session='. $session);
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
