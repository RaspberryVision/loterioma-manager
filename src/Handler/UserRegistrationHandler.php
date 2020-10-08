<?php


namespace App\Handler;

use App\Entity\User;
use App\Message\UserRegistration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserRegistrationHandler  implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * UserRegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UserRegistration $message)
    {
        $user = json_decode($message->getContent());

        $user1 = new User();
        $user1->setEmail($user->email)
            ->setPassword($user->password);

        $this->entityManager->persist($user1);
        $this->entityManager->flush();
    }
}