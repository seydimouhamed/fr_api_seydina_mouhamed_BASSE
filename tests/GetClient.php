<?php
namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetClient  extends WebTestCase
{
    
    public function createAuthenticatedClient(string $login, string $password): KernelBrowser
    {
        $client = static::createClient();
        $infos=["username"=>$login,
               "password"=>$password];
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($infos)
        );
        $this->assertResponsestatusCodeSame(Response::HTTP_OK);
        $data = \json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', \sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');

        return $client;
    }

}
