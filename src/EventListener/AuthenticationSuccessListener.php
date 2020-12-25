<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Exception\LockedException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener{
    
       

         /**
         * @param AuthenticationSuccessEvent $event
         */
        public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
        {
            $data = $event->getData();
            $user = $event->getUser();
            

           // if (!$user instanceof UserInterface) {
           //     return;
           // }
          // dd($user->getArchivage());
          if(\method_exists($user,'getArchivage') && $user->getArchivage()){
            throw new LockedException();
          }
            $data['role'] = $user->getRoles()[0];
            

            $event->setData($data);
        }
}