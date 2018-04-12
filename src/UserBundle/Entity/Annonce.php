<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="annonce_ibfk_1", columns={"idUser"})})
 * @ORM\Entity
 */
class Annonce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="annonceText", type="text", length=65535, nullable=true)
     */
    private $annoncetext;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDePartage", type="datetime", nullable=false)
     */
    private $datedepartage = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="likecount", type="integer", nullable=true)
     */
    private $likecount;

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikecount", type="integer", nullable=true)
     */
    private $dislikecount;

    /**
     * @var integer
     *
     * @ORM\Column(name="signalercount", type="integer", nullable=true)
     */
    private $signalercount;

    /**
     * @ORM\Column(name="nomImage", type="string", length=255)
     */
    private $nomImage;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAnnoncetext()
    {
        return $this->annoncetext;
    }

    /**
     * @param string $annoncetext
     */
    public function setAnnoncetext($annoncetext)
    {
        $this->annoncetext = $annoncetext;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDatedepartage()
    {
        return $this->datedepartage;
    }

    /**
     * @param \DateTime $datedepartage
     */
    public function setDatedepartage($datedepartage)
    {
        $this->datedepartage = $datedepartage;
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
    public function getLikecount()
    {
        return $this->likecount;
    }

    /**
     * @param int $likecount
     */
    public function setLikecount($likecount)
    {
        $this->likecount = $likecount;
    }

    /**
     * @return int
     */
    public function getDislikecount()
    {
        return $this->dislikecount;
    }

    /**
     * @param int $dislikecount
     */
    public function setDislikecount($dislikecount)
    {
        $this->dislikecount = $dislikecount;
    }

    /**
     * @return int
     */
    public function getSignalercount()
    {
        return $this->signalercount;
    }

    /**
     * @param int $signalercount
     */
    public function setSignalercount($signalercount)
    {
        $this->signalercount = $signalercount;
    }

    /**
     * @return mixed
     */
    public function getNomImage()
    {
        return $this->nomImage;
    }

    /**
     * @param mixed $nomImage
     */
    public function setNomImage($nomImage)
    {
        $this->nomImage = $nomImage;
    }
    /**
     * @Assert\File(mimeTypes={ "image/*" })
     */
    public $file;

    public function getWebPath()
    {
        return null ===$this->nomImage?null:$this->getUploadDir().'/'.$this->nomImage;
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
        $this->nomImage=$this->file->getClientOriginalName();
        $this->file=null;
    }


}

