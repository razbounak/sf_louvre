<?php

namespace AccueilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="AccueilBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateJour", type="date")
     */
    private $dateJour;

    /**
     * @var boolean
     * @ORM\Column(name="demiJournee", type="boolean")
     */
    private $demiJournee;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateResa", type="date", nullable=true)
     */
    private $dateResa;
    
    public function __construct()
    {
        $this->dateJour = new \DateTime();
        $this->billet = new ArrayCollection();
    }

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
     * Set email
     *
     * @param string $email
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateJour
     *
     * @param \DateTime $dateJour
     * @return Reservation
     */
    public function setDateJour($dateJour)
    {
        $this->dateJour = $dateJour;

        return $this;
    }

    /**
     * Get dateJour
     *
     * @return \DateTime 
     */
    public function getDateJour()
    {
        return $this->dateJour;
    }

    public function getBillet()
    {
        return $this->billet;
    }

    /**
     * Set demiJournee
     *
     * @param boolean $demiJournee
     * @return Reservation
     */
    public function setDemiJournee($demiJournee)
    {
        $this->demiJournee = $demiJournee;

        return $this;
    }

    /**
     * Get demiJournee
     *
     * @return boolean 
     */
    public function getDemiJournee()
    {
        return $this->demiJournee;
    }

    /**
     * Set dateResa
     *
     * @param \DateTime $dateResa
     * @return Reservation
     */
    public function setDateResa($dateResa)
    {
        $this->dateResa = $dateResa;

        return $this;
    }

    /**
     * Get dateResa
     *
     * @return \DateTime
     */
    public function getDateResa()
    {
        return $this->dateResa;
    }
}
