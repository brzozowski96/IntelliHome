<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Wpisz swoje imię.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Wpisz tutaj swoje prawidłowe imię"
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message = "Wpisz swoje nazwisko."
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Wpisz tutaj swoje prawidłowe nazwisko"
     * )
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     *
     * @Assert\Choice(
     *     choices = { "m", "f"},
     *     message = "Wybierz płeć."
     * )
     */
    protected $sex;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @Assert\Date(
     *     message = "Wybierz datę."
     * )
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $role;

    /**
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Wybierz prawidłowy plik JPEG lub PNG"
     * )
     */
    protected $avatarFile;

//    /**
//     * @Assert\NotBlank(
//     *     message="Musisz zaakceptować regulamin"
//     * )
//     */
//    protected $rules;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * @param mixed $avatarFile
     */
    public function setAvatarFile($avatarFile)
    {
        $this->avatarFile = $avatarFile;
    }

//    /**
//     * @return mixed
//     */
//    public function getRules()
//    {
//        return $this->rules;
//    }
//
//    /**
//     * @param mixed $rules
//     */
//    public function setRules($rules)
//    {
//        $this->rules = $rules;
//    }
}