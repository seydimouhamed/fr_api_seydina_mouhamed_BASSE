<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Services\UserService;
use Doctrine\ORM\EntityManager;
use App\Services\SendMailService;
use App\Repository\UserRepository;
use App\Repository\ApprenantRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PromotionController extends AbstractController
{
    private $serializer;
    private $validator;
    private $userService;
    private $encoder;
    private $repoApp;

    public function __construct(
        ApprenantRepository $repoApp,
        UserPasswordEncoderInterface $encoder,
        UserService $userService,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em)
    {
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->userService= $userService;
        $this->encoder = $encoder;
        $this->repoApp = $repoApp;
        
    }
    /**
     * 
     * @Route(
     *     name="addPromotions",
     *     path="/api/admin/promos",
     *     methods={"POST"}
     * )
     */
    public function add(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //recupéré tout les données de la requete
        //$promo=json_decode($request->getContent(),true);
        $promo=$request->request->all();
        
        $promo = $this->serializer->denormalize($promo,"App\Entity\Promotion",true);
        
        $photo = $request->files->get("avatar");
          
        if($photo)
        {
            $photoBlob = fopen($photo->getRealPath(),"rb");
            
             $promo->setAvatar($photoBlob);
        }
        if(!$promo->getFabrique())
        {
            $promo->setFabrique("Sonatel académie");
        }

        $errors = $this->validator->validate($promo);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }

        

        //creation dun groupe pour la promo
       
        $group = new Groupe();
       // $date = date('Y-m-d');
        $group->setName('Groupe Générale')
              ->setCreateAt(new \DateTime())
              ->setStatut('ouvert')
              ->setType('groupe principal')
              ->setPromotion($promo);
             // dd($promo);
        
        //----------------------------------------------------
        //DEBUT AJOUT DES UTILISATEURS
        //----------------------------------------------------
         
        $userData = json_decode(($request->request->get('userDatas')), true);
            // traitement des etudiants qui déjà été inscrit dans la plateform
        $lastApp = array_filter($userData, function($app){
            return isset($app['id']);
        });

        foreach($lastApp as $key => $app){
         
            $apprenant = $this->repoApp->find($app['id']);
            if($apprenant)
                $group->addApprenant($apprenant);
        }
            // traitement des etudiants pas encore inscrites dans la plateform


            
        $newApp = array_filter($userData, function($app){
           return !isset($app['id']);
        });

        // Get apprenant profil object;
        $profilApprenant=  $this->serializer->denormalize("/api/admin/profils/4","App\Entity\Profil",true);
        foreach($newApp as $app){
            $apprenant = new Apprenant();
            $apprenant->setFirstname($app['email'])
                      ->setLastname($app['email'])
                      ->setUsernme($app['email'])
                      ->setPassword($this->encoder->encodePassword($apprenant,"passe123"))
                      ->setEmail($app['email'])
                      ->setProfil($profilApprenant)
                      ->setGenre('u')
                      ->setAdresse('u')
                      ->setTelephone('u');
            $em->persist($apprenant);
            $group->addApprenant($apprenant);
        }
        
        // return $this->json("ttette",201);
        //----------------------------------------------------
        // FIN AJOUT DES UTILISATEURS
        //----------------------------------------------------
        
           
        //----------------------------------------------------
        // DEBUT RECUPERATION DES DONNEES DU FICHIERS EXCELS
        //-----------------------------------------------------
        
        $doc = $request->files->get("document");

        $file= IOFactory::identify($doc);
        
        $reader= IOFactory::createReader($file);

        $spreadsheet=$reader->load($doc);
        
        $tab_apprenants= $spreadsheet->getActivesheet()->toArray();
        
        $attr=$tab_apprenants[0];
        $tabrjz=[];

        for($i=1;$i<count($tab_apprenants);$i++)
        {
            $apprenant=new Apprenant();
            for($k=0;$k<count($tab_apprenants[$i]);$k++)
            {
                $data=$tab_apprenants[$i][$k];
                if($attr[$k]=="Password")
                {
                    $apprenant->setPassword($this->encoder->encodePassword($apprenant,$data));
                }else
                {
                    $apprenant->{"set".$attr[$k]}($data);
                }
            }
            $apprenant->setProfil($profilApprenant);
            $apprenant->setPassword($this->encoder->encodePassword($apprenant,"passe123"));
            $apprenant->setUsernme($apprenant->getFirstname().'_'.$this->userService->getRandomUserName());
            $apprenant->setArchivage(0);
            $em->persist($apprenant);
            $group->addApprenant($apprenant);
        }
        //------------------------------------------------------
        //FIN RECUPERATION DES DONNEES DU FICHIERS EXCELS
        //-----------------------------------------------------
             $em->persist($group);

        //dd($group);
             $promo->addGroupe($group);
            //$promo->setArchivage(false);
      
              $em->persist($promo);

              
       // return $this->json("success",201);
             $em->flush();
        
        return $this->json($promo,201);
        //return $this->json("success", 401);
     }

}
