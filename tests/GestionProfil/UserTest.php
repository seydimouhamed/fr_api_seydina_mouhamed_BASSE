<?php
declare(strict_types=1);

namespace App\Tests\GestionProfil;

use App\Tests\GetClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;


class UserTest extends WebTestCase 
{
    private $_getClient;
    public function __construct(GetClient $_getClient)
    {
        $this->_getClient= $_client;
    }
    public function testGetUsers()
    {
      //  $getClient=new GetClient();
        $client = $this->_getClient->createAuthenticatedClient('admin1','passe123');
        $client->request('GET','/api/admin/users');

        $this->assertSame(200,$client->getResponse()->getStatusCode());
    }

    public function testAdd()
    {
        $client = $this->_getClient->createAuthenticatedClient("admin1","passe123");
            $data= ["username"=> "testUserName",
            "firstname"=> "testFN1",
            "lastname"=> "testLN1",
            "email"=>"test1@yahoo.com",
             "password"=>"passer",
            "plainPassword"=>"passer",
            "profil"=>"/api/admin/profils/1"];
            $client->request('POST','/api/admin/users',$data);
    
            $this->assertResponseIsSuccessful();
        
    }

    public function testArchivage()
    {

        $client = $this->_getClient->createAuthenticatedClient("admin1","passe123");
        $client->request('DELETE','/api/admin/users/2');

        $this->assertResponseIsSuccessful();
    }
}