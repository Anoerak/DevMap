<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserDetail;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function createUser(Request $request, EntityManagerInterface $entityManager, UserService $userService): Response
    {
        // // We check if the user is already registered
        // $responseCheck = $userService->checkUser($request, $entityManager);

        // if ($responseCheck) {
        //     return $responseCheck;
        // }

        // We create the User via UserService
        $response = $userService->createUser($request, $entityManager);


        return $response;
    }

    #[Route('/api/user/activate', name: 'app_api_user_activate', methods: ['PUT'])]
    public function activateUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        // We get the email from the request
        $data = json_decode($request->getContent(), true);

        // We get the User from the DB based on the email
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user) {
            $response = new JsonResponse([
                'message' => 'User not found'
            ], 404);

            $response->headers->add([
                'Content-Type' => 'text/plain',
                'Access-Control-Allow-Origin' => '*',
            ]);
            $response->prepare($request);
            $response->send();

            return $response;
        }

        // We activate/deactivate the User
        if ($user->isActive() === true) {
            $user->setActive(false);

            $entityManager->persist($user);
            $entityManager->flush();

            $response = new JsonResponse([
                "status" => 200,
                "message" => "User deactivated",
                "statusText" => "user deactivated",
                "data" => [
                    "username" => $user->getUsername(),
                    "isActive" => $user->isActive()
                ]
            ], 200);
        } else {
            $user->setActive(true);

            $entityManager->persist($user);
            $entityManager->flush();

            $response = new JsonResponse([
                "status" => 200,
                "message" => "User activated",
                "statusText" => "user activated",
                "data" => [
                    "username" => $user->getUsername(),
                    "isActive" => $user->isActive()
                ]
            ], 200);
        }

        $response->headers->add([
            'Content-Type' => 'text/plain',
            'Access-Control-Allow-Origin' => '*',
        ]);
        $response->prepare($request);
        $response->send();

        return $response;
    }


    #[Route('/api/user/delete', name: 'app_api_user_delete', methods: ['DELETE'])]
    public function deleteUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        // We get the email from the request
        $data = json_decode($request->getContent(), true);

        // We get the User from the DB based on the email
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        $userDetail = $entityManager->getRepository(UserDetail::class)->findOneBy(['user' => $user]);

        // We delete the User and its UserDetail
        if (!$user || !$userDetail) {
            $response = new JsonResponse([
                'message' => 'User not found'
            ], 404);

            $response->headers->add([
                'Content-Type' => 'text/plain',
                'Access-Control-Allow-Origin' => '*',
            ]);
            $response->prepare($request);
            $response->send();

            return $response;
        }

        $entityManager->remove($userDetail);
        $entityManager->remove($user);

        $entityManager->flush();

        // We check that the User and its UserDetail have been deleted
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        $userDetail = $entityManager->getRepository(UserDetail::class)->findOneBy(['user' => $user]);

        if ($user || $userDetail) {
            $response = new JsonResponse([
                'message' => 'User not deleted'
            ], 400);

            $response->headers->add([
                'Content-Type' => 'text/plain',
                'Access-Control-Allow-Origin' => '*',
            ]);
            $response->prepare($request);
            $response->send();

            return $response;
        }


        $response = new JsonResponse([
            'message' => 'User deleted'
        ], 200);

        $response->headers->add([
            'Content-Type' => 'text/plain',
            'Access-Control-Allow-Origin' => '*',
        ]);
        $response->prepare($request);
        $response->send();

        return $response;
    }
}
