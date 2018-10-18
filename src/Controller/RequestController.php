<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Structure;
use App\Service\FileUploader;
use App\Entity\Image;
use App\Entity\Gallery;
use App\Entity\Room;
use App\Entity\Reservation;

class RequestController extends AbstractController
{
    /**
     * @Route("/request/sendreservation", name="request-sendmail")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

      if($mailto = $request->request->get('mail')){
        $phoneto = $request->request->get('phone');
        $nameto = $request->request->get('name');
        $messageto = $request->request->get('message');
        $date = $request->request->get('date');
        $huesp = $request->request->get('huesp');

        $message = (new \Swift_Message('Hello Email'))
                     ->setSubject('Solicitud Reservación - Hotel Santorini')
                     ->setFrom('joscri2698@gmail.com','Hotel Santorini')
                     //->setTo('reservas@hotelsantorini.cl')
                     ->setTo('josepuma@sayrin.cl')
                     ->setBody(
                       $this->renderView(
                         'emails/reservation.html.twig',
                          array(
                            'name' => $nameto,
                            'phone' => $phoneto,
                            'message' => $messageto,
                            'mail' => $mailto,
                            "date" => $date,
                            "huesp" => $huesp
                        )
                       ),
                       'text/html'
                     );

                     $mailer->send($message);
                     $entityManager = $this->getDoctrine()->getManager();
                     $res = new Reservation();
                     $res->setName($nameto);
                     $res->setEmail($mailto);
                     $res->setPhone($phoneto);
                     $res->setHuesp($huesp);
                     $res->setDate($date);
                     $res->setRooms(1);
                     $res->setMessage($messageto);

                     $entityManager->persist($res);
                     $entityManager->flush();

                     return new JsonResponse(array(



                     ));

      }

        return $this->render('request/index.html.twig', [
            'controller_name' => 'RequestController',
        ]);
    }

    /**
     * @Route("/request/updatecontent", name="request-update")
     */
     public function updateContent(Request $request){

       if($id = $request->request->get('id')){
         $value = $request->request->get('value');

         $entityManager = $this->getDoctrine()->getManager();
         $item = $entityManager->getRepository(Structure::class)->find($id);

         if(!$item){

         }

         $item->setValue($value);
         $entityManager->flush();

         return new JsonResponse(array(  ));

       }

     }

     /**
      * @Route("/request/updatecontentimage", name="request-update-image")
      */
      public function updateImageContent(Request $request, FileUploader $fileUploader){

        if($imagefile = $request->files->get('file')){
          $id = $request->request->get('id');

          $entityManager = $this->getDoctrine()->getManager();
          $item = $entityManager->getRepository(Structure::class)->find($id);
          $fileName = $fileUploader->upload($imagefile);

          if(!$item){

          }

          $item->setValue($fileName);
          $entityManager->flush();

          return new JsonResponse(array(
               'imagePath' => $fileName
           ));

        }

      }

      /**
       * @Route("/request/uploadcontentimage", name="request-upload-image-home")
       */
       public function uploadImageContent(Request $request, FileUploader $fileUploader){

         if($imagefile = $request->files->get('file')){
           $id = $request->request->get('galleryid');

           $entityManager = $this->getDoctrine()->getManager();
           $fileName = $fileUploader->upload($imagefile);

           $gallery = $entityManager->getRepository(Gallery::class)->find($id);

           $image = new Image();
           $image->setPath($fileName);
           $image->setGallery($gallery);

           $entityManager->persist($image);
           $entityManager->flush();

           $newIdentifier = $image->getId();

           return new JsonResponse(array(
                'imagePath' => $fileName,
                'id' => $newIdentifier
            ));

         }

       }

       /**
        * @Route("/request/deleteimage", name="request-delete-image")
        */
        public function deleteImage(Request $request){

           if($id = $request->request->get('id')){

             $entityManager = $this->getDoctrine()->getManager();
             $item = $entityManager->getRepository(Image::class)->find($id);

             if(!$item){

             }

             $entityManager->remove($item);
             $entityManager->flush();

             return new JsonResponse(array(

              ));

           }

        }

        /**
         * @Route("/request/insertroom", name="request-insert-room")
         */
         public function insertRoom(Request $request, FileUploader $fileUploader){
             if($imagefile = $request->files->get('file')){
                $name = $request->request->get('name');
                $intro = $request->request->get('intro');
                $contentHtml = $request->request->get('contentHtml');

                $entityManager = $this->getDoctrine()->getManager();
                $room = new Room();
                $room->setName($name);
                $room->setIntro($intro);
                $room->setDescription($contentHtml);

                $fileName = $fileUploader->upload($imagefile);

                $room->setCover($fileName);

                $entityManager->persist($room);
                $entityManager->flush();

                $newIdentifier = $room->getId();

                return new JsonResponse(array(
                     'imagePath' => $fileName,
                     'id' => $newIdentifier
                 ));

             }
         }

         /**
          * @Route("/request/deleteroom", name="request-delete-room")
          */
          public function deleteRoom(Request $request){

             if($id = $request->request->get('id')){

               $entityManager = $this->getDoctrine()->getManager();
               $item = $entityManager->getRepository(Room::class)->find($id);
               $entityManager->remove($item);
               $entityManager->flush();

               return new JsonResponse(array(

                ));

             }

          }
}
