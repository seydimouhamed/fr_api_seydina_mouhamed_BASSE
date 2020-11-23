<?php

namespace App\EventSubscriber;

// use App\Services\SendMailService;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;

 class MailEventSubscriber 
//implements EventSubscriberInterface
 {
//     private $mailService;
//     public function __construct(SendMailService $mailService)
//     {
//         $this->mailService = $mailService;
//     }

//     public static function getSubscribedEvents()
//     {
//         return [
//             KernelEvents::VIEW => ['sendMail',EventPriorities::POST_WRITE]
//         ];
//     }

//     public function sendMail(ViewEvent $event):void 
//     {
//         $user = $event->getControllerResult();
//         $method = $event->getRequest()->getMethod();

//         if( !$user instanceof User || Request::Method_POST !== $method ){
//             return;
//         }

//         $this->mailService->sendMail($user,'registration');

//     }
 }