<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SendMailService
{
   // private $_template;
    private $mailer;

    public function __construct(
        ContainerInterface $container,
        \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($user,$type,$title=null)
    {
        if(!$title)
            $title = $type;
        $message =(new \Swift_Message($title))
            ->setFrom("seydinabasse@gmail.com")
            ->setTo($user->getEmail())
            ->setBody(
                // $this->_template(
                //     'emails/'.$type.'.html.twig',
                //     ['data'=>$user]
                // ),
                // 'text/html' moussa10ba@gmail.com
                "Voici votre mot de passe<h1 style='color:red'> ".$user->getPlainPassword()."</h1>",
            );
            $this->mailer->send($message);

         return true;
    }
}
