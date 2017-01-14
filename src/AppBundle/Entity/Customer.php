<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 13/01/17
 * Time: 21:35
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class Customer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    /**
     * @ORM\Column(type="string")
     */
    protected $password;
    /**
     * @ORM\Column(type="string")
     */
    protected $username;


    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($name)
    {
        $this->username = $name;
    }
    public function setEmail($mail)
    {
        $this->email = $mail;
    }
    public function setPassword($pass)
    {
        $this->password = $pass;
    }

}