<?php
namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    public function getLatestReviews(int $carId, CarRepository $carRepository)
    {
        return $carRepository->latestCarReviewsWithAboveSixStars($carId);
    }
}