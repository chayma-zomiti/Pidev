<?php
/**
 * Created by PhpStorm.
 * User: jamel
 * Date: 31-Mar-18
 * Time: 6:49 AM
 */

namespace UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use UserBundle\Entity\Mail;

class MailController extends Controller
{

    public function indexAction($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('jamel.mustapha94@gmail.com')
            ->setTo('mustapha.jamel@esprit.tn')

            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);


    }


}