<?php

namespace VeterinaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListveterinaireController extends Controller
{
    public function indexAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==1){
            $em = $this->getDoctrine()->getManager();

            $vet = $em->getRepository('UserBundle:User')->findBy(array('fonctionuser'=>2));

            return $this->render('vet/index.html.twig', array(
                'vet' => $vet,
            ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
    }


    public function rechercheAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==1){
            $em = $this->getDoctrine()->getManager();

            $vet = $em->getRepository('UserBundle:User')->rech($_GET['search']);

            return $this->render('vet/index.html.twig', array(
                'vet' => $vet,
            ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
    }
}
