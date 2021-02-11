<?php
namespace App\DataPersister;

use App\Entity\Referentiel;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class ReferentielDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Referentiel;
    }

    public function persist($data, array $context = [])
    {
        
      // call your persistence layer to save $data

      $this->em->persist($data);
      $this->em->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);   
        $this->em->persist($data);
        $this->em->flush();
    }
}