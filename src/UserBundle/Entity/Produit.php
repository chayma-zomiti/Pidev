<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk_produit", columns={"idUser"}), @ORM\Index(name="cat_fk", columns={"idCategorie"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleProduit", type="string", length=45, nullable=true)
     */
    private $libelleproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionProduit", type="string", length=45, nullable=true)
     */
    private $descriptionproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="etatProduit", type="string", length=45, nullable=true)
     */
    private $etatproduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prixProduit", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixproduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $iduser;


    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie",onDelete="CASCADE")
     * })
     */
    private $idcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="imageProduit", type="string", length=100, nullable=true)
     */
    private $imageproduit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajout", type="datetime", nullable=false)
     */
    private $dateajout = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock = '1';

    /**
     * Produit constructor.
     * @param \DateTime $dateajout
     */
    public function __construct()
    {
        $this->dateajout = new \DateTime();
    }


    /**
     * @return int
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * @param int $idproduit
     */
    public function setIdproduit($idproduit)
    {
        $this->idproduit = $idproduit;
    }

    /**
     * @return string
     */
    public function getLibelleproduit()
    {
        return $this->libelleproduit;
    }

    /**
     * @param string $libelleproduit
     */
    public function setLibelleproduit($libelleproduit)
    {
        $this->libelleproduit = $libelleproduit;
    }

    /**
     * @return string
     */
    public function getDescriptionproduit()
    {
        return $this->descriptionproduit;
    }

    /**
     * @param string $descriptionproduit
     */
    public function setDescriptionproduit($descriptionproduit)
    {
        $this->descriptionproduit = $descriptionproduit;
    }

    /**
     * @return string
     */
    public function getEtatproduit()
    {
        return $this->etatproduit;
    }

    /**
     * @param string $etatproduit
     */
    public function setEtatproduit($etatproduit)
    {
        $this->etatproduit = $etatproduit;
    }

    /**
     * @return float
     */
    public function getPrixproduit()
    {
        return $this->prixproduit;
    }

    /**
     * @param float $prixproduit
     */
    public function setPrixproduit($prixproduit)
    {
        $this->prixproduit = $prixproduit;
    }

    /**
     * @return int
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param int $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return int
     */
    public function getIdcategorie()
    {
        return $this->idcategorie;
    }

    /**
     * @param int $idcategorie
     */
    public function setIdcategorie($idcategorie)
    {
        $this->idcategorie = $idcategorie;
    }

    /**
     * @return string
     */
    public function getImageproduit()
    {
        return $this->imageproduit;
    }

    /**
     * @param string $imageproduit
     */
    public function setImageproduit($imageproduit)
    {
        $this->imageproduit = $imageproduit;
    }

    /**
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * @param \DateTime $dateajout
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @Assert\File(maxSize="2000k")
     */
    public $file;

    public function getWebPath()
    {
        return null ===$this->imageproduit?null:$this->getUploadDir().'/'.$this->imageproduit;
    }
    protected function getUploadRootDir()
    {

        return dirname(__DIR__).'/../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        return 'productImages';
    }
    public function uploadProductImage()
    {
        $this->file->move($this->getUploadRootDir(),$this->file->getClientOriginalName());
        $this->imageproduit=$this->file->getClientOriginalName();
        $this->file=null;
    }




}

