<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Services\NasaImageHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/image', name: 'app_image')]
#[IsGranted('ROLE_GOOGLE')]
class NasaImageController extends AbstractController
{
    public function __construct(
        private readonly NasaImageHandler $nasaImageHandler,
        private readonly ImageRepository $imageRepository
    ) {

    }
    #[Route('/today', name: '_today')]
    public function fetchTodayImage(): Response
    {
        $today = new \DateTime();

        if (empty($this->imageRepository->findByDate($today))) {
            return $this->render('image.html.twig', ['message' => 'No image available for today (don\'t worry, it\'s not your fault :D, let\'s try again after fetch the today\'s image)']);
        }

        $data = $this->nasaImageHandler->getImageData($today);

        return $this->render('image.html.twig', ['data' => $data]);
    }

}