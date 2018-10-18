<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Structure;
use App\Entity\Gallery;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

      $entityManager = $this->getDoctrine()->getManager();

      $items = $this->getDoctrine()
      ->getRepository(Structure::class)
      ->findAll();

      $gallery = $this->getDoctrine()
      ->getRepository(Gallery::class)
      ->find(1)->getImages();

        return $this->render('frontend/home/index.html.twig', [
            'title' => 'Inicio',
            'items' => $items,
            'gallery' => $gallery
        ]);
    }
}
