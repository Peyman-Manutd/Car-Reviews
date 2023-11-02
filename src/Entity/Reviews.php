<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Link;
use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
#[ApiResource(
    shortName: 'reviews',
    normalizationContext: ['groups' => ['reviews.read']],
    denormalizationContext: ['groups' => ['reviews.write']],
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Patch(),
        new Delete()
    ]
)]
#[ApiResource(
    normalizationContext: ['groups' => ['reviews.read']],
    shortName: 'reviews',
    description: 'Retrieves the collection of reviews from a specific car',
    uriTemplate: 'cars/{carId}/reviews',
    uriVariables: [
        'carId' => new Link(fromClass: Car::class, toProperty: 'car')
    ],
    operations: [new GetCollection()]
)]
#[ApiResource(
    normalizationContext: ['groups' => ['reviews.read']],
    shortName: 'reviews',
    description: 'Retrieves the collection of top rated latest reviews from a specific car',
    uriTemplate: 'cars/{carId}/latest_reviews',
    uriVariables: [
        'carId' => new Link(fromClass: Car::class, toProperty: 'car')
    ],
    controller: 'App\Controller\CarController::getLatestReviews',
    operations: [new GetCollection()]
)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['reviews.read', 'reviews.write', 'car.read'])]
    private ?int $rating = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['reviews.read', 'reviews.write', 'car.read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'reviews', targetEntity: Car::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reviews.read', 'reviews.write'])]
    private ?Car $car = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reviews.read', 'reviews.write'])]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
