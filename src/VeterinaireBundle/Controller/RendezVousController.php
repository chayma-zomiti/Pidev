<?php

namespace VeterinaireBundle\Controller;

use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function indexAction(Request $request)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==2){
        $em = $this->getDoctrine()->getManager();

        $rendezVouses = $em->getRepository('VeterinaireBundle:RendezVous')->findBy(array('idVet'=>$user->getId()));
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $rendezVouses, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );

        return $this->render('rendezvous/index.html.twig', array(
            'pagination' => $pagination,
            'rdv'=>$rendezVouses
        ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
    }

    /**
     * Creates a new rendezVous entity.
     *
     */
    public function newAction($id,Request $request)
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
                /**
                 * @var UploadedFile $file
                 */
                $file = $rendezVous->getPhotoa();
                $file->move(
                    $this->getParameter('rdv_upload'), $file->getClientOriginalName());
                $rendezVous->setPhotoa($file->getClientOriginalName());


                $rendezVous->setIdVet($id);
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
            /**
             * @var UploadedFile $file
             */
            $file = $rendezVous->getPhotoa();
            $file->move(
                $this->getParameter('rdv_upload'), $file->getClientOriginalName());
            $rendezVous->setPhotoa($file->getClientOriginalName());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('r_show', array('id' => $rendezVous->getId()));
        }

        return $this->render('rendezvous/edit.html.twig', array(
            'rendezVous' => $rendezVous,
            'form' => $editForm->createView(),
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
            return $this->render('rendezvous/reche.html.twig', array(
                'rendezVouses' => $rendezVouses,
            ));
        }else{
            return $this->redirectToRoute('user_homepage');

        }
        }

    public function generatePdfAction(RendezVous $rendezVous){
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        $html= $this->render('vet/pdf.html.twig', array(
            'rendezVous' => $rendezVous,
        ));

        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P','A4','en');
        $html2pdf->writeHTML($html->getContent());
        $html2pdf->output($rendezVous->getTypea().'-'.$user->getFullname().'.pdf');

    }


    /**
     * Displays a form to edit an existing rendezVous entity.
     *
     */
    public function edit2Action(Request $request, RendezVous $rendezVous)
    {

        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();


        if ($user!=='anon.' && $user->getFonctionuser()==2){

            $deleteForm = $this->createDeleteForm($rendezVous);
        $editForm = $this->createForm('VeterinaireBundle\Form\confirmationType', $rendezVous);
        $editForm->handleRequest($request);
        $file = $rendezVous->getPhotoa();
        if ($editForm->isSubmitted()) {

            $rendezVous->setPhotoa($file);
            $rendezVous->setVerif(true);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('r_show', array('id' => $rendezVous->getId()));
        }

        return $this->render('rendezvous/confirmation.html.twig', array(
            'rendezVous' => $rendezVous,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }else{
return $this->redirectToRoute('user_homepage');

}

}
}
