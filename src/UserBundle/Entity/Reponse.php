<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="reponse_ibfk_1", columns={"idCommentaire"})})
 * @ORM\Entity
 */
class Reponse
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
     * @ORM\Column(name="textreponse", type="text", length=65535, nullable=true)
     */
    private $textreponse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereponse", type="datetime", nullable=false)
     */
    private $datereponse = 'CURRENT_TIMESTAMP';

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
     * @ORM\Column(name="signaler", type="integer", nullable=true)
     */
    private $signaler;

    /**
     * @var \Commentaire
     *
     * @ORM\ManyToOne(targetEntity="Commentaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCommentaire", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $idcommentaire;

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
    public function getTextreponse()
    {
        return $this->textreponse;
    }

    /**
     * @param string $textreponse
     */
    public function setTextreponse($textreponse)
    {
        $this->textreponse = $textreponse;
    }

    /**
     * @return \DateTime
     */
    public function getDatereponse()
    {
        return $this->datereponse;
    }

    /**
     * @param \DateTime $datereponse
     */
    public function setDatereponse($datereponse)
    {
        $this->datereponse = $datereponse;
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
    public function getSignaler()
    {
        return $this->signaler;
    }

    /**
     * @param int $signaler
     */
    public function setSignaler($signaler)
    {
        $this->signaler = $signaler;
    }

    /**
     * @return \Commentaire
     */
    public function getIdcommentaire()
    {
        return $this->idcommentaire;
    }

    /**
     * @param \Commentaire $idcommentaire
     */
    public function setIdcommentaire($idcommentaire)
    {
        $this->idcommentaire = $idcommentaire;
    }


}

