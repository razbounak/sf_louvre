<?php

namespace AccueilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity(repositoryClass="AccueilBundle\Repository\PaysRepository")
 */
class Pays
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha", type="string", length=255)
     */
    private $alpha;

    /**
     * @var string
     *
     * @ORM\Column(name="nomFr", type="string", length=255)
     */
    private $nomFr;

    /**
     * @var string
     *
     * @ORM\Column(name="nomGb", type="string", length=255)
     */
    private $nomGb;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alpha
     *
     * @param string $alpha
     * @return Pays
     */
    public function setAlpha($alpha)
    {
        $this->alpha = $alpha;

        return $this;
    }

    /**
     * Get alpha
     *
     * @return string 
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    /**
     * Set nomFr
     *
     * @param string $nomFr
     * @return Pays
     */
    public function setNomFr($nomFr)
    {
        $this->nomFr = $nomFr;

        return $this;
    }

    /**
     * Get nomFr
     *
     * @return string 
     */
    public function getNomFr()
    {
        return $this->nomFr;
    }

    /**
     * Set nomGb
     *
     * @param string $nomGb
     * @return Pays
     */
    public function setNomGb($nomGb)
    {
        $this->nomGb = $nomGb;

        return $this;
    }

    /**
     * Get nomGb
     *
     * @return string 
     */
    public function getNomGb()
    {
        return $this->nomGb;
    }
}
