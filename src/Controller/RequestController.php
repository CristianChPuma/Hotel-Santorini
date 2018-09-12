<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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

                     return new JsonResponse(array(
          
                                         ));

      }

        return $this->render('request/index.html.twig', [
            'controller_name' => 'RequestController',
        ]);
    }
}
