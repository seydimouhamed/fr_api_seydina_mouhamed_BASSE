<?php
namespace App\DataPersister;

use App\Entity\ProfilSortie;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class ProfilSortieDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof ProfilSortie;
    }

    public function persist($data, array $context = [])
    {
      // call your persistence layer to save $data
      return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);   
        $this->em->persist($data);
        foreach($data->getUsers() as $u)
        {
          $u->setArchivage(true);
        }
        $this->em->flush();
    }
}