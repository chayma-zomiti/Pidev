<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Mail;
use UserBundle\Entity\User;

/**
 * Annonce controller.
 *
 * @Route("annonce")
 */
class AnnonceController extends Controller
{
    /**
     * Lists all annonce entities.
     *
     * @Route("/", name="annonce_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $datenow=new \DateTimeImmutable();
        $datenowStringType = $datenow->format('Y-m-d');


        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository('UserBundle:Annonce')->findAll();

        foreach ($annonces as $annonce){
            $CreatedDate=$annonce->getDatedepartage();
            $CreatedDate_StringType = $CreatedDate->format('Y-m-d');

            $date_fin_duree = date('Y-m-d', strtotime($CreatedDate_StringType.'+ 10 Days'));


            if ( strtotime($datenowStringType)>strtotime($date_fin_duree) )
            {

                $em->remove($annonce);
                $em->flush($annonce);
            }

            $list = $em->getRepository('UserBundle:Annonce')->findAll();
            
        }
        return $this->render('annonce/index.html.twig', array(
            'annonces' => $list
        ));
    }

    /**
     * Creates a new annonce entity.
     *
     * @Route("/new", name="annonce_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {


        $annonce = new Annonce();
        $form = $this->createForm('UserBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $annonce->uploadProductImage();

            $annonce->setIduser(        $id =  $this->getUser()->getId());
            $annonce->setDatedepartage(new \DateTimeImmutable());
            $annonce->setLikecount(0);
            $annonce->setDislikecount(0);
            $annonce->setSignalercount(0);
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/new.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/{id}", name="annonce_show")
     * @Method("GET")
     */
    public function showAction(Annonce $annonce)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($annonce);
        $commentaires= $em->getRepository('UserBundle:Commentaire')->findBy(array('idannonce' => $annonce ));

        foreach ($commentaires as $commentaire){
            $reponses= $em->getRepository('UserBundle:Reponse')->findBy(array('idcommentaire' => $commentaire ));

        }

        return $this->render('annonce/show.html.twig', array(
            'annonce' => $annonce,
            'commentaires' => $commentaires,

            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonce entity.
     *
     * @Route("/{id}/edit", name="annonce_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Annonce $annonce)
    {
        $deleteForm = $this->createDeleteForm($annonce);
        $editForm = $this->createForm('UserBundle\Form\AnnonceType', $annonce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_edit', array('id' => $annonce->getId()));
        }

        return $this->render('annonce/edit.html.twig', array(
            'annonce' => $annonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonce entity.
     *
     * @Route("/{id}", name="annonce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Annonce $annonce)
    {
        $form = $this->createDeleteForm($annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonce);
            $em->flush();
        }

        return $this->redirectToRoute('annonce_index');
    }

    /**
     * Creates a form to delete a annonce entity.
     *
     * @param Annonce $annonce The annonce entity
     *
     */
    private function createDeleteForm(Annonce $annonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('annonce_delete', array('id' => $annonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
  /**
     * like a annonce entity.
    *
    * @Route("/{id}/like", name="annonce_like")
    */
    public function likeAction( Request $request,Annonce $annonce)
    {


        $annonce->setLikecount($annonce->getLikecount()+1);
        $em = $this->getDoctrine()->getManager();
        $em->merge($annonce);
        $em->flush();

        return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));

    }
    /**
 * dislike a annonce entity.
 *
 * @Route("/{id}/dislike", name="annonce_dislike")
 */
    public function dislikeAction(Request $request, Annonce $annonce)
    {


        $annonce->setDislikecount($annonce->getDislikecount()+1);
        $em = $this->getDoctrine()->getManager();
        $em->merge($annonce);
        $em->flush();

        return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));

    }
    /**
     * dislike a annonce entity.
     *
     * @Route("/{id}/signaler", name="annonce_signaler")
     */
    public function signalerAction(Request $request, Annonce $annonce)
    {


        $annonce->setSignalercount($annonce->getSignalercount()+1);
        $em = $this->getDoctrine()->getManager();
        $em->merge($annonce);
        $em->flush();

        return $this->redirectToRoute('annonce_show', array('id' => $annonce->getId()));

    }
}
