<?php

namespace UserBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use UserBundle\Entity\Servicelist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Servicelist controller.
 *
 */
class ServicelistController extends Controller
{
    /**
     * Lists all servicelist entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $servicelists = $em->getRepository('UserBundle:Servicelist')->findAll();

        return $this->render('servicelist/index.html.twig', array(
            'servicelists' => $servicelists,
        ));
    }

    /**
     * Creates a new servicelist entity.
     *
     */
    public function newAction(Request $request)
    {
        $servicelist = new Servicelist();
        $form = $this->createForm('UserBundle\Form\ServicelistType', $servicelist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $servicelist->setCreator( $this->container->get('security.token_storage')->getToken()->getUser()->getid());
            $em->persist($servicelist);
            $em->flush();

            return $this->redirectToRoute('servicelist_show', array('id' => $servicelist->getId()));
        }

        return $this->render('servicelist/new.html.twig', array(
            'servicelist' => $servicelist,
            'form' => $form->createView(),
        ));
    }


    public function SMSAction(Servicelist $servicelist , $prix){
        $em = $this->getDoctrine()->getManager();
        $twilio = $this->get('twilio.api');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $creator = $em->getRepository('UserBundle:User')->findOneBy(array('id'=>$servicelist->getCreator()));
        $message = $twilio->account->messages->sendMessage(
            '+447492882612', // From a Twilio number in your account
            $servicelist->getPhonenumber(), // Text any number
            "Contacter " . $user->getFullname() . " sur proposition de : " . $prix
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        return new Response($message->sid);

    }

    /**
     * Finds and displays a servicelist entity.
     *
     */
    public function showAction(Servicelist $servicelist)
    {
        $deleteForm = $this->createDeleteForm($servicelist);

        return $this->render('servicelist/show.html.twig', array(
            'servicelist' => $servicelist,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing servicelist entity.
     *
     */
    public function editAction(Request $request, Servicelist $servicelist)
    {
        $deleteForm = $this->createDeleteForm($servicelist);
        $editForm = $this->createForm('UserBundle\Form\ServicelistType', $servicelist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('servicelist_edit', array('id' => $servicelist->getId()));
        }

        return $this->render('servicelist/edit.html.twig', array(
            'servicelist' => $servicelist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a servicelist entity.
     *
     */
    public function deleteAction(Request $request, Servicelist $servicelist)
    {
        $form = $this->createDeleteForm($servicelist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($servicelist);
            $em->flush();
        }

        return $this->redirectToRoute('servicelist_index');
    }

    /**
     * Creates a form to delete a servicelist entity.
     *
     * @param Servicelist $servicelist The servicelist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Servicelist $servicelist)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicelist_delete', array('id' => $servicelist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function SearchAction($libelle)
    {
        if($libelle =="all"){
            $em = $this->getDoctrine()->getManager();

            $serviceslist = $em->getRepository('UserBundle:Servicelist')->findAll();
        }
        else {
            $repository = $this->getDoctrine()
                ->getRepository(Servicelist::class);

            $query = $repository->createQueryBuilder('s')
                ->where('s.description LIKE :libelle')
                ->setParameter('libelle', '%'.$libelle.'%')
                ->getQuery();
            $serviceslist = $query->getResult();
        }

        return $this->render(':servicelist:search.html.twig',array('servicelists' => $serviceslist)) ;
    }
}
