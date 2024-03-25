<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthController extends AbstractController
{

    #[Route('/connect/google', name: 'connect_google_start')]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google_main') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect();
    }

    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectCheckAction()
    {
        if (!$this->getUser()) {
            return new JsonResponse(array('status' => false, 'message' => 'User not found :('));
        }
        return $this->redirectToRoute('app_image_today');
    }
}