<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="commentaire_ibfk_1", columns={"idAnnonce"})})
 * @ORM\Entity
 */
class Commentaire
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
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=true)
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommentaire", type="datetime", nullable=false)
     */
    private $datecommentaire = 'CURRENT_TIMESTAMP';

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
     * @var \Annonce
     *
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnnonce", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $idannonce;
    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $idusercommentaire;
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
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return \DateTime
     */
    public function getDatecommentaire()
    {
        return $this->datecommentaire;
    }

    /**
     * @param \DateTime $datecommentaire
     */
    public function setDatecommentaire($datecommentaire)
    {
        $this->datecommentaire = $datecommentaire;
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
     * @return \Annonce
     */
    public function getIdannonce()
    {
        return $this->idannonce;
    }

    /**
     * @param \Annonce $idannonce
     */
    public function setIdannonce($idannonce)
    {
        $this->idannonce = $idannonce;
    }

    /**
     * @return int
     */
    public function getIdusercommentaire()
    {
        return $this->idusercommentaire;
    }

    /**
     * @param int $iduser
     */
    public function setIdusercommentaire($idusercommentaire)
    {
        $this->idusercommentaire = $idusercommentaire;
    }


}

