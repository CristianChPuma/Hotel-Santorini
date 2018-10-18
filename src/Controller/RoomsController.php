<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;

class RoomsController extends AbstractController
{
    /**
     * @Route("/hoteleria/habitaciones", name="rooms")
     */
    public function index()
    {
      $rooms = $this->getDoctrine()
      ->getRepository(Room::class)
      ->findAll();

        return $this->render('frontend/rooms/index.html.twig', [
            'title' => 'Habitaciones',
            'rooms' => $rooms
        ]);
    }
}
