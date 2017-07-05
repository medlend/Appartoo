<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04/07/17
 * Time: 14:12
 */

namespace User\UserBundle\Entity;

use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="profile")
 */
class Profile
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var string
     *
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=228,nullable=true)
     */
    private $famille;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=228,nullable=true)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=228,nullable=true)
     */
    private $nourriture;

    /**
     *
     * @ORM\Column(type="boolean")
     */
    private $firstLogin;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="User\UserBundle\Entity\Bonobo", inversedBy="profile")
     */
    private $bonobo;




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
     * Set age
     *
     * @param integer $age
     *
     * @return Profile
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Profile
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return Profile
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set nourriture
     *
     * @param string $nourriture
     *
     * @return Profile
     */
    public function setNourriture($nourriture)
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    /**
     * Get nourriture
     *
     * @return string
     */
    public function getNourriture()
    {
        return $this->nourriture;
    }

    /**
     * Set bonobo
     *
     * @param \User\UserBundle\Entity\Bonobo $bonobo
     *
     * @return Profile
     */
    public function setBonobo(\User\UserBundle\Entity\Bonobo $bonobo = null)
    {
        $this->bonobo = $bonobo;

        return $this;
    }

    /**
     * Get bonobo
     *
     * @return \User\UserBundle\Entity\Bonobo
     */
    public function getBonobo()
    {
        return $this->bonobo;
    }

    /**
     * @return mixed
     */
    public function getFirstLogin()
    {
        return $this->firstLogin;
    }

    /**
     * @param mixed $firstLogin
     * @return Profile
     */
    public function setFirstLogin($firstLogin)
    {
        $this->firstLogin = $firstLogin;
        return $this;
    }


}
