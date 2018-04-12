<?php
/**
 * Created by PhpStorm.
 * User: jamel
 * Date: 30-Mar-18
 * Time: 2:08 PM
 */

namespace UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* Mail
*
 * @ORM\Table(name="mail")
 * @ORM\Entity
*/
class Mail
{

    /**
     * Mail constructor.
     */
    public function __construct(User $user,$text)
    {
        $this->setEmail($user->getEmail());
        $this->setNom($user->getFullname());
        $this->setText($text);
    }
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
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=50, nullable=true)
     */
    private $text;



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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }



    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}