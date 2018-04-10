<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="text", length=65535, nullable=false)
     */
    private $fullname;

    /**
     * @var integer
     *
     * @ORM\Column(name="fonctionUser", type="integer", nullable=false)
     */
    private $fonctionuser;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dnaiss", type="datetime", nullable=false)
     */
    private $dnaiss;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", nullable=false)
     */
    private $sexe;
    /**
     * @var string
     *
     * @ORM\Column(name="imgpath", type="string", nullable=true)
     */
    private $imgpath;

    /**
     * @var integer
     *
     * @ORM\Column(name="validated", type="integer", nullable=true)
     */
    private $validated=0;

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
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return int
     */
    public function getFonctionuser()
    {
        return $this->fonctionuser;
    }

    /**
     * @param int $fonctionuser
     */
    public function setFonctionuser($fonctionuser)
    {
        $this->fonctionuser = $fonctionuser;
    }

    /**
     * @return string
     */
    public function getImgpath()
    {
        return $this->imgpath;
    }

    /**
     * @param string $imgpath
     */
    public function setImgpath($imgpath)
    {
        $this->imgpath = $imgpath;
    }

    /**
     * @return int
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param int $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * @return \DateTime
     */
    public function getDnaiss()
    {
        return $this->dnaiss;
    }

    /**
     * @param \DateTime $dnaiss
     */
    public function setDnaiss($dnaiss)
    {
        $this->dnaiss = $dnaiss;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }




}

