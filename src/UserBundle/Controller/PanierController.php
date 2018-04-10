<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Produit;

/**
 * Panier controller.
 *
 */
class PanierController extends Controller
{
    /**
     * Lists all panier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = array();
        $total= 0;
        $paniers = $em->getRepository('UserBundle:Panier')->findBy(array('iduser'=>$this->container->get('security.token_storage')->getToken()->getUser()->getid()));
        if($paniers == null){
            return $this->redirectToRoute('produit_index');
        }

        foreach ($paniers as $p){
            $prod = $em->getRepository('UserBundle:Produit')->findOneBy(array('idproduit'=>$p->getIdproduit()));
            array_push($produits,$prod);
            $total = $total + ($p->getPrix() * $p->getQuantity());
        }
        return $this->render('panier/index.html.twig', array(
            'paniers' => $paniers,
            'produits' => $produits,
            'lg'=>count($paniers)-1,
            'total'=>$total
        ));
    }

    /**
     * Creates a new panier entity.
     *
     */
    public function newAction(Produit $idprod ,$quantety)
    {

            $em = $this->getDoctrine()->getManager();
            $panier = new Panier();
            $panier->setIdproduit($idprod->getIdproduit());
            $panier->setIduser($this->container->get('security.token_storage')->getToken()->getUser()->getid());
            $panier->setQuantity($quantety);
            $panier->setPrix($idprod->getPrixproduit());

            $findexist = $em->getRepository('UserBundle:Panier')->findOneBy(array('idproduit'=>$idprod->getIdproduit(),'iduser'=>$panier->getIduser()));
            if($findexist != null){
                $findexist->setQuantity($findexist->getQuantity()+$quantety);
            }
            else {
                $em->persist($panier);

            }
            $em->flush();



        return $this->redirectToRoute('panier_index');
    }




    public function successAction($iduser){
        $em = $this->getDoctrine()->getManager();
        $paniers = $em->getRepository('UserBundle:Panier')->findBy(array('iduser'=>$iduser));
        foreach ($paniers as $p){
            $em->remove($p);
        }

        $em->flush();
        return $this->redirectToRoute('produit_index');
    }


    /**
     * Deletes a panier entity.
     *
     */
    public function deleteAction(Request $request, Panier $panier)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($panier);
            $em->flush();

        return $this->redirectToRoute('panier_index');
    }

    /**
     * Creates a form to delete a panier entity.
     *
     * @param Panier $panier The panier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Panier $panier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panier_delete', array('idproduit' => $panier->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
