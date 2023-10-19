<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

// We create a service to check if a user is already registered

class UserService extends AbstractController
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

	public function createUser(Request $request, EntityManagerInterface $entityManager): Response
	{
		// We get the POST data
		$data = json_decode($request->getContent(), true);

		// We check if the user is already registered
		$user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['user']['email']]);
		if ($user) {
			$response = new JsonResponse([
				'status' => 400,
				'title' => 'Error',
				'message' => 'This email is already registered. Please try again with another email.'
			]);

			$response->headers->add([
				'Content-Type' => 'text/plain',
				'Access-Control-Allow-Origin' => '*',
			]);
			$response->prepare($request);
			$response->send();

			return $response;
		}


		$hashedEmail = $this->encoder->getPasswordHasher('bcrypt')->hash($data['user']['email']);

		$userEntity = new User();
		$userDetailEntity = new UserDetail();

		$userEntity->setUsername($data['user']['username']);
		// $userEntity->setEmail($hashedEmail);
		$userEntity->setEmail($data['user']['email']);
		$userEntity->setActive(false);
		$userEntity->setRoles(['ROLE_USER']);

		$entityManager->persist($userEntity);

		$userDetailEntity->setUser($userEntity);
		$userDetailEntity->setCountry($data['country']);
		$userDetailEntity->setCity($data['city']);
		$userDetailEntity->setZipcode($data['zipcode']);
		$userDetailEntity->setShortZipcode($data['shortZipcode']);
		$userDetailEntity->setSpecialty($data['specialty']);
		$userDetailEntity->setStack($data['stack']);
		$userDetailEntity->setGeometryType($data['geometryType']);
		$userDetailEntity->setGeometryCoordinates($data['geometryCoordinates']);

		$entityManager->persist($userDetailEntity);

		$entityManager->flush();


		// We check if the user has been created
		$user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['user']['email']]);

		// We throw an error if the user has not been created
		if (!$user) {
			$response = new JsonResponse([
				'status' => 400,
				'title' => 'Error',
				'message' => 'An error occurred while creating your account. Please try again.'
			]);

			$response->headers->add([
				'Content-Type' => 'text/plain',
				'Access-Control-Allow-Origin' => '*',
			]);
			$response->prepare($request);
			$response->send();

			return $response;
		}

		// We send a confirmation email to the user
		$response = new JsonResponse([
			'status' => 200,
			'title' => 'Success',
			'message' => 'Congratulations' . ' ' . $user->getUsername() . '!' . ' ' . 'Your account has been created successfully. Go check your email in order to activate your account.',
		]);

		$response->headers->add([
			'Content-Type' => 'text/plain',
			'Access-Control-Allow-Origin' => '*',
		]);
		$response->prepare($request);
		$response->send();

		return $response;
	}
}
