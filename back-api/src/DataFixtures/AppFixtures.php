<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Country;
use App\Entity\TechStack;
use App\Entity\UserDetail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AppFixtures extends Fixture
{
    private $faker;
    private $encoder;

    public function __construct()
    {
        $this->encoder = new PasswordHasherFactory([
            'bcrypt' => [
                'algorithm' => 'bcrypt'
            ]
        ]);
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(__DIR__ . '/../../../front/src/lib/data/db.json');
        // We create our list of Country based on our JSON Db.
        $data = json_decode($json, true)['country'];

        foreach ($data as $country) {
            $entity = new Country();
            $entity->setName($country['Name']);
            $entity->setCode($country['Code']);
            $manager->persist($entity);
        }

        // We create our list of Languages/Frameworks/Librairies based on our JSON Db.
        $data = json_decode($json, true)['stack'];

        foreach ($data as $stack) {
            $entity = new TechStack();
            $entity->setName($stack);
            $entity->setPopularity(0);
            $manager->persist($entity);
        }

        // We create our list of Users and Users' Details based on our JSON Db.
        $data = json_decode($json, true)['geojson'];

        $admin = new User();
        $admin->setUsername('anørak');
        // $admin->setEmail($this->encoder->getPasswordHasher('bcrypt')->hash('admin@admin.fr'));
        $admin->setEmail('admin@admin.fr');
        $admin->setActive(true);
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $adminDetail = new UserDetail();
        $adminDetail->setUser($admin);
        $adminDetail->setCountry('France');
        $adminDetail->setCity('Limoges');
        $adminDetail->setZipcode('87000');
        $adminDetail->setShortZipcode('87');
        $adminDetail->setSpecialty('Fullstack');
        $adminDetail->setStack(['PHP', 'Symfony', 'React', 'MySQL', 'MongoDB', 'Docker', 'Git', 'JS', 'Vue', 'Svelte']);
        $adminDetail->setGeometryType('Point');
        $adminDetail->setGeometryCoordinates([1.261105, 45.835424]);

        $manager->persist($adminDetail);

        foreach ($data[0]['features'] as $user) {
            $entity = new User();
            // We generate a fake username with faker
            $entity->setUsername($this->faker->userName);
            // We generate a fake email with faker and we encrypt it
            // $hashed = $this->encoder->getPasswordHasher('bcrypt')->hash($this->faker->email);
            // $entity->setEmail($hashed);
            $entity->setEmail($this->faker->email);
            $entity->setActive(true);
            $entity->setRoles(['ROLE_USER']);

            $manager->persist($entity);

            // We create a UserDetail for each User
            $userDetail = new UserDetail();
            $userDetail->setUser($entity);
            $userDetail->setCountry($user['properties']['country']);
            $userDetail->setCity($user['properties']['city']);
            $userDetail->setZipcode($user['properties']['zipcode']);
            $userDetail->setShortZipcode($user['properties']['department']);
            $userDetail->setSpecialty($user['properties']['speciality']);
            $userDetail->setStack($user['properties']['stack']);
            $userDetail->setGeometryType($user['geometry']['type']);
            $userDetail->setGeometryCoordinates($user['geometry']['coordinates']);

            $manager->persist($userDetail);
        }

        $manager->flush();
    }
}
