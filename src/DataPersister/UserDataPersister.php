<?php
namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $_passwordEncoder;
    private $_request;
    public function __construct(EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordEncoder,
        RequestStack $request)
    {
        $this->em=$em;
        $this->_passwordEncoder = $passwordEncoder;
        $this->_request = $request->getCurrentRequest();
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
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