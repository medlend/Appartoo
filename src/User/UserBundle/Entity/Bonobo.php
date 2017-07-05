<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04/07/17
 * Time: 10:00
 */

namespace User\UserBundle\Entity;

namespace User\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bonobo")
 */

class Bonobo extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Many Users have Many Users.
     * @ORM\ManyToMany(targetEntity="Bonobo", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * Many Users have many Users.
     * @ORM\ManyToMany(targetEntity="Bonobo", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    /**
     * @ORM\OneToOne(targetEntity="User\UserBundle\Entity\Profile", mappedBy="bonobo",cascade={"persist","remove"})
     */
    private $profile;


    public function __construct() {
        parent::__construct();
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profile=new Profile();
        $this->profile->setBonobo($this);
        $this->profile->setFirstLogin(true);
    }



    /**
     * Add friendsWithMe
     *
     * @param \User\UserBundle\Entity\Bonobo $friendsWithMe
     *
     * @return Bonobo
     */
    public function addFriendsWithMe(\User\UserBundle\Entity\Bonobo $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \User\UserBundle\Entity\Bonobo $friendsWithMe
     */
    public function removeFriendsWithMe(\User\UserBundle\Entity\Bonobo $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriend
     *
     * @param \User\UserBundle\Entity\Bonobo $myFriend
     *
     * @return Bonobo
     */
    public function addMyFriend(\User\UserBundle\Entity\Bonobo $myFriend)
    {
        $this->myFriends[] = $myFriend;

        return $this;
    }

    /**
     * Remove myFriend
     *
     * @param \User\UserBundle\Entity\Bonobo $myFriend
     */
    public function removeMyFriend(\User\UserBundle\Entity\Bonobo $myFriend)
    {
        $this->myFriends->removeElement($myFriend);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }

    /**
     * Set profile
     *
     * @param \User\UserBundle\Entity\Profile $profile
     *
     * @return Bonobo
     */
    public function setProfile(\User\UserBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \User\UserBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
