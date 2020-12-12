<?php
namespace App\DataPersister;

use App\Entity\Groupe;
use App\Entity\Promotion;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class PromoDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $request;
    private $repoApprenant;
    private $repoFormateur;
    public function __construct(
        EntityManagerInterface $em, 
        RequestStack $requestStack, 
        ApprenantRepository $repoApprenant,
        FormateurRepository $repoFormateur)
    {
        $this->em=$em;
        $this->request= $requestStack->getCurrentRequest();
        $this->repoApprenant=$repoApprenant;
        $this->repoFormateur=$repoFormateur;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Promotion;
    }

    public function persist($data, array $context = [])
    {
        // dd();
    if($context["item_operation_name"]==="put_promo_apprenant")
    {
            $d= json_decode($this->request->getContent(),true);
            $group=$data->getGroupes()->filter(
                function(Groupe $group){
                    return $group->getType()=="principal";
                }
            )[0];
            foreach($d as $action => $tabId )
            {
                foreach($tabId as $id)
                {
                    $app=$this->repoApprenant->find($id);
                    if($app){
                        $group->{$action."Apprenant"}($app);
                    }
                }
            }
            $this->em->persist($group);
      }
      if($context["item_operation_name"]==="put_promo_formateur")
      {
              $d= json_decode($this->request->getContent(),true);
              
              foreach($d as $action => $tabId )
              {
                  foreach($tabId as $id)
                  {
                      $app=$this->repoFormateur->find($id);
                      if($app){
                          $data->{$action."Formateur"}($app);
                      }
                  }
              }

      $this->em->persist($data);
      }
      
      if($context["item_operation_name"]==="put_groupe_status")
      {
            
            
            $d= json_decode($this->request->getContent(),true);
            $statut = $d['statut'];
          
            $groups=$data->getGroupes()->filter(
                function(Groupe $group, $idGroupe){
                    $idGroupe =$this->request->get('groupe');
                    return $group->getId()== $idGroupe;
                }
            );
            
            foreach($groups as $group)
            {
                $group->setStatut($statut);
                $this->em->persist($group);
                $this->em->flush();
                return $group;
            }
      }
    
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