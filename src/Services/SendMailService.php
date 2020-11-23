<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SendMailService
{
    // private $_template;
    // private $mailer;

    // public function __construct(
    //     ContainerInterface $container,
    //     Swift_Mailer $mailer)
    // {
    //     $this->_template = $container->get('template');
    //     $this->mailer = $mailer;
    // }

    // public function sendMail($user,$type,$title)
    // {
        // if(!title)
        //     $title = $type;
    //     $message =(new Swift_Message($title))
    //         ->setFrom($currentUser)
    //         ->setTo($user->getEmail())
    //         ->setBody(
    //             $this->_template(
    //                 'emails/'.$type.'.html.twig',
    //                 ['data'=>$user]
    //             ),
    //             'text/html'
    //         );
    //         $mailer->send($message);

    //      return true;
    // }
}
