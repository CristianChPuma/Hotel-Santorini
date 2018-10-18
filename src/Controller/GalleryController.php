<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallery;

class GalleryController extends AbstractController
{
    /**
     * @Route("/galeria", name="gallery")
     */
    public function index()
    {

       $entityManager = $this->getDoctrine()->getManager();

       $gallery = $this->getDoctrine()
       ->getRepository(Gallery::class)
       ->find(2)->getImages();

        return $this->render('frontend/gallery/index.html.twig', [
            'title' => 'Galería',
            'gallery' => $gallery
        ]);
    }
}
