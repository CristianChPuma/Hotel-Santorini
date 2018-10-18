<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Structure;

class ServicesController extends AbstractController
{
    /**
     * @Route("/servicios", name="services")
     */
    public function index()
    {

      $items = $this->getDoctrine()
      ->getRepository(Structure::class)
      ->findAll();

        return $this->render('frontend/services/index.html.twig', [
            'title' => 'Servicios',
            'items' => $items
        ]);
    }
}
