<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Structure;
use App\Entity\Gallery;
use App\Entity\Room;
use App\Entity\Reservation;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
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

        return $this->render('admin/index.html.twig', [
            'title' => 'Administración',
            'items' => $items,
            'gallery' => $gallery
        ]);
    }

    /**
     * @Route("/admin/galeria", name="admin-gallery")
     */
    public function showGallery(){

      $gallery = $this->getDoctrine()
      ->getRepository(Gallery::class)
      ->find(2)->getImages();

      return $this->render('admin/gallery/index.html.twig', [
          'title' => 'Galería',
          'gallery' => $gallery
      ]);
    }

    /**
     * @Route("/admin/eventos", name="admin-events")
     */
    public function showEvents(){
      return $this->render('admin/events/index.html.twig', [
          'title' => 'Eventos',
      ]);
    }

    /**
     * @Route("/admin/reservas", name="admin-reserves")
     */
    public function showReserves(){

      $items = $this->getDoctrine()
      ->getRepository(Reservation::class)
      ->findAll();

      return $this->render('admin/reserves/index.html.twig', [
          'title' => 'Reservas',
          'reservations' => $items
      ]);
    }

    /**
     * @Route("/admin/servicios", name="admin-services")
     */
    public function showServices(){

      $items = $this->getDoctrine()
      ->getRepository(Structure::class)
      ->findAll();

      return $this->render('admin/services/index.html.twig', [
          'title' => 'Servicios',
          'items' => $items,
      ]);
    }

    /**
     * @Route("/admin/habitaciones", name="admin-rooms")
     */
    public function showRooms(){

      $rooms = $this->getDoctrine()
      ->getRepository(Room::class)
      ->findAll();

      return $this->render('admin/rooms/index.html.twig', [
          'title' => 'Habitaciones',
          'rooms' => $rooms,
      ]);
    }

}
