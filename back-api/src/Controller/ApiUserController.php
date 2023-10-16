<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserDetail;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class ApiUserController extends AbstractController
{

    private $encoder;

    public function __construct()
    {
        $this->encoder = new PasswordHasherFactory([
            'bcrypt' => [
                'algorithm' => 'bcrypt'
            ]
        ]);
    }

    #[Route('/api/user', name: 'app_api_user', methods: ['POST'])]
    public function postUser(Request $request, EntityManagerInterface $entityManager, UserService $userService): Response
    {
        // We first check if the user already exists
        $response = $userService->checkUser($request, $entityManager);

        if ($response->getStatusCode() === 400) {
            $response->send();

            return $response;
        }

        // We create the User via UserService
        $userService->createUser($request, $entityManager);

        // We catch the createUser response and send it back to the front
        $response = new Response(
            'User created',
            Response::HTTP_CREATED,
            ['content-type' => 'text/html']
        );

        $response->send();

        return $response;
    }
}