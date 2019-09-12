<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class User implements UserInterface
{
    use EntityTrait;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     *
     * @return (Role|string)[] The user roles
     */
    /**
     * @var string|null
     * @ORM\Column()
     */
    private $username;
    /**
     * @var string|null
     * @ORM\Column()
     */

    private $password;
    public function getRoles(): array
    {
        return [self::ROLE_USER, self::ROLE_ADMIN];
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // nothing to do :)
    }
}