<?php
namespace App\DataPersister;

use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class CompetenceDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Competence;
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