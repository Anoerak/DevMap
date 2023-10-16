<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

	public function checkUser(Request $request, EntityManagerInterface $entityManager): Response
	{
		// We get the POST data
		$data = json_decode($request->getContent(), true);

		// We loop through the users to check if the user already exists
		$users = $entityManager->getRepository(User::class)->findAll();
		$usersEmails = [];

		foreach ($users as $user) {
			$usersEmails[] = $user->getEmail();
		}

		foreach ($usersEmails as $userEmail) {
			if ($this->encoder->getPasswordHasher('bcrypt')->verify($userEmail, $data['user']['email'])) {
				$response = new Response();
				$response->setStatusCode(400);
				$response->setContent('User already exists');

				return $response;
			}
		}

		return new Response(
			'User does not exist',
			Response::HTTP_OK,
			['content-type' => 'text/html']
		);
	}

	public function createUser(Request $request, EntityManagerInterface $entityManager): Response
	{
		// We get the POST data
		$data = json_decode($request->getContent(), true);

		$hashedEmail = $this->encoder->getPasswordHasher('bcrypt')->hash($data['user']['email']);

		$userEntity = new User();
		$userDetailEntity = new UserDetail();

		$userEntity->setUsername($data['user']['username']);
		$userEntity->setEmail($hashedEmail);
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
		$user = $entityManager->getRepository(User::class)->findOneBy(['email' => $hashedEmail]);

		// We throw an error if the user has not been created
		if (!$user) {
			$response = new Response();
			$response->setStatusCode(400);
			$response->setContent('User not created');

			$response->send();

			return $response;
		}

		return new Response();
	}
}