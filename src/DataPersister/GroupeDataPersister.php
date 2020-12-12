<?php
namespace App\DataPersister;

use App\Entity\Groupe;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class GroupeDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $request;
    private $repoApprenant;
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack, ApprenantRepository $repoApprenant)
    {
        $this->em=$em;
        $this->request= $requestStack->getCurrentRequest();
        $this->repoApprenant=$repoApprenant;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Groupe;
    }

    public function persist($data, array $context = [])
    {
        //dd($context);
      if($context["item_operation_name"]==="addApprenantGroup")
      {
        $d= json_decode($this->request->getContent(),true);
        foreach($d['apprenantIDs'] as $id )
        {
            $app=$this->repoApprenant->find($id);
            if($app){
                $data->addApprenant($app);
            }
        }
      }
     // dd($data);
      $this->em->persist($data);
      $this->em->flush();
      return $data;
    }

    public function remove($data, array $context = [])
    {

       // $data->setArchivage(true);

      if($context["item_operation_name"]==="deleteAppGroup")
      {
         // dd('tzferyezt');
        $idUser=$this->request->get('id2');
            $app=$this->repoApprenant->find($idUser);
            if($app){
                $data->removeApprenant($app);
            }
      }
        
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }
}