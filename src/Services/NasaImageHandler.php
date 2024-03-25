<?php

namespace App\Services;

use DateTime;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaImageHandler
{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ImageRepository $imageRepository,
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function nasaData(array $nasaDataApi): void
    {
        if (!empty($nasaDataApi)) {
            $date = DateTime::createFromFormat('Y-m-d', $nasaDataApi['date']);
            $image = new Image();
            $image->setDate($date)
                ->setTitle($nasaDataApi['title'])
                ->setExplanation($nasaDataApi['explanation'])
                ->setUrlImage($nasaDataApi['url'])
                ->setMediaType($nasaDataApi['media_type']);

            $this->em->persist($image);
            $this->em->flush();
        }
    }

    public function fetchData(): array
    {
        $data = [];
        $date = new \DateTime(date('Y-m-d'));

        if (empty($this->imageRepository->findOneByDate($date))) {
            $apikey = 'https://api.nasa.gov/planetary/apod?api_key=' . $_ENV['NASA_API_KEY'];
            try {
                $response = $this->httpClient->request(
                    'GET',
                    $apikey
                );

                if ($response->getStatusCode() === 200) {
                    $data = $response->toArray();
                } else {
                    throw new \RuntimeException('Something went wrong');
                }
            } catch (\RuntimeException $e) {
                throw new \RuntimeException('Something went wrong' . $e);
            }
        }
        return $data;

    }

    public function getImageData($date): ?Image
    {
        $imageData = $this->imageRepository->findOneByDate($date);
        if (!empty($imageData) && 'image' !== $imageData->getMediaType()) {
            $date->modify('-1 day');
            $imageData = $this->getImageData($date);
        }
        return $imageData;
    }
}