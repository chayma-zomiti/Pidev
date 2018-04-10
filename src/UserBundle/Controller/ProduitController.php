<?php

namespace UserBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use UserBundle\Entity\Produit;
use UserBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('UserBundle:Produit')->findAll();
        $categories = $em->getRepository('UserBundle:Categorie')->findAll();
        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
            'categories'=>$categories
        ));
    }
    public function SearchAction($libelle)
    {
        if($libelle =="all"){
            $em = $this->getDoctrine()->getManager();

            $products = $em->getRepository('UserBundle:Produit')->findAll();
        }
        else {
            $repository = $this->getDoctrine()
                ->getRepository(Produit::class);

            $query = $repository->createQueryBuilder('p')
                ->where('p.libelleproduit LIKE :libelle')
                ->setParameter('libelle', '%'.$libelle.'%')
                ->getQuery();
            $products = $query->getResult();
        }

        return $this->render(':produit:search.html.twig',array('produits' => $products)) ;
    }

    public function BycatAction(Categorie $categorie)
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('UserBundle:Produit')->findBy(['idcategorie' => $categorie->getidcategorie()]);
        $categories = $em->getRepository('UserBundle:Categorie')->findAll();
        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
            'categories'=>$categories
        ));
    }

    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('UserBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $produit->uploadProductImage();
            $produit->setIduser( $this->container->get('security.token_storage')->getToken()->getUser()->getid());
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('idproduit' => $produit->getIdproduit()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($produit);
        //$user = $em->getRepository('UserBundle:User')->findOneBy(['id' => $produit->getIduser()]);
        $cat = $em->getRepository('UserBundle:Categorie')->findOneBy(['idcategorie' => $produit->getIdcategorie()]);
        if($cat==null){
            $catname ="";
        }else{
            $catname = $cat->getNomcategorie();
        }
        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
            'categorie'=>$catname,
           // 'user'=>$user->getFullname(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('UserBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $produit->uploadProductImage();
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('produit_edit', array('idproduit' => $produit->getIdproduit()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('idproduit' => $produit->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    public function chartAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('UserBundle:Produit')->findBy(array('iduser'=> $this->container->get('security.token_storage')->getToken()->getUser()->getid()) );
        $data = array(['Produit libele','Quantité']);
        foreach ($produits as $p){
            array_push($data , [$p->getLibelleproduit() , $p->getStock()]);
        }
           // var_dump($data);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Stock Par Produit');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('produit/chart.html.twig', array('piechart' => $pieChart , 'products'=>$produits));
    }
}
