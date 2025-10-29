<?php

namespace App\Controller;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country?}', name: 'app_weather')]
    public function city(
        string $city,
        ?string $country,
        MeasurementRepository $repository
    ): Response {
        $measurements = $repository->findByLocation($city, $country);

        if (!$measurements) {
            throw $this->createNotFoundException("Nie znaleziono danych dla: {$city}");
        }

        $location = $measurements[0]->getLocation();

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
