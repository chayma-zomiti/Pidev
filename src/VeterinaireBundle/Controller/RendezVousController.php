<?php

namespace VeterinaireBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use VeterinaireBundle\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rendezvous controller.
 *
 */
class RendezVousController extends Controller
{
    /**
     * Lists all rendezVous entities.
     *
     */
    public function indexAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==2){
        $em = $this->getDoctrine()->getManager();

        $rendezVouses = $em->getRepository('VeterinaireBundle:RendezVous')->findAll();

        return $this->render('rendezvous/index.html.twig', array(
            'rendezVouses' => $rendezVouses,
        ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
    }

    /**
     * Creates a new rendezVous entity.
     *
     */
    public function newAction(Request $request)
    {

        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


            if ($user!=='anon.' && $user->getFonctionuser()==1){
            $rendezVous = new Rendezvous();
            $form = $this->createForm('VeterinaireBundle\Form\RendezVousType', $rendezVous);
            $form->handleRequest($request);
            $rendezVous->setNom($user->getFullname());
            $rendezVous->setPrenom($user->getFullname());
            $rendezVous->setDateRdv(new \DateTime());
            $rendezVous->setEmail($user->getEmail());
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($rendezVous);
                $em->flush();

                return $this->redirectToRoute('r_show', array('id' => $rendezVous->getId()));
            }
           echo $user->getFonctionuser();
            return $this->render('rendezvous/new.html.twig', array(
                'rendezVous' => $rendezVous,
                'form' => $form->createView(),
            ));
            }else{
                return $this->redirectToRoute('user_homepage');

           }
    }

    /**
     * Finds and displays a rendezVous entity.
     *
     */
    public function showAction(RendezVous $rendezVous)
    {
        $deleteForm = $this->createDeleteForm($rendezVous);

        return $this->render('rendezvous/show.html.twig', array(
            'rendezVous' => $rendezVous,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rendezVous entity.
     *
     */
    public function editAction(Request $request, RendezVous $rendezVous)
    {
        $deleteForm = $this->createDeleteForm($rendezVous);
        $editForm = $this->createForm('VeterinaireBundle\Form\RendezVousType', $rendezVous);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('r_edit', array('id' => $rendezVous->getId()));
        }

        return $this->render('rendezvous/edit.html.twig', array(
            'rendezVous' => $rendezVous,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rendezVous entity.
     *
     */
    public function deleteAction(Request $request, RendezVous $rendezVous)
    {
        $form = $this->createDeleteForm($rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rendezVous);
            $em->flush();
        }

        return $this->redirectToRoute('r_index');
    }

    /**
     * Creates a form to delete a rendezVous entity.
     *
     * @param RendezVous $rendezVous The rendezVous entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RendezVous $rendezVous)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('r_delete', array('id' => $rendezVous->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function rechercheAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==2){
            $em = $this->getDoctrine()->getManager();

            $rendezVouses = $em->getRepository('VeterinaireBundle:RendezVous')->rech($_GET['search']);

            return $this->render('rendezvous/index.html.twig', array(
                'rendezVouses' => $rendezVouses,
            ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
    }
}
