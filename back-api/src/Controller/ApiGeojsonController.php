<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserDetailRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGeojsonController extends AbstractController
{
    // #[ApiResource]
    #[Route('/api/getAllGeojson', name: 'app_api_get_geojson', methods: ['GET'])]
    public function getAll(UserDetailRepository $userDetailRepository): Response
    {
        $data = $userDetailRepository->findAll();
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($data as $user) {
            $feature = [
                'type' => 'Feature',
                'id' => $user->getId(),
                'properties' => [
                    'username' => $user->getUser()->getUsername(),
                    'email' => $user->getUser()->getEmail(),
                    'country' => $user->getCountry(),
                    'zipcode' => $user->getZipcode(),
                    'shortZipcode' => $user->getShortZipcode(),
                    'city' => $user->getCity(),
                    'specialty' => $user->getSpecialty(),
                    'stack' => $user->getStack(),
                    'active' => $user->getUser()->isActive(),
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $user->getGeometryCoordinates()[0],
                        $user->getGeometryCoordinates()[1]
                    ]
                ]
            ];

            array_push($geojson['features'], $feature);
        }

        return $this->json($geojson);
    }
}