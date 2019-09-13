<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(unique=true, length=190)
     * U
     */

    private $password;
    /**
     * @var string|null
     * @ORM\Column()
     */
    private $articlesCollection;
    public function __construct()
    {
        $this->articlesCollection = new ArrayCollection();
    }

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

    public function getArticlesCollection(): iterable
    {
        return $this->articlesCollection;
    }

    public function addArticle(Articles $articles): self {
        $this->articlesCollection->add($articles);
        return $this;
    }

    public function removeArticle(Articles $articles): self
    {
        $this->articlesCollection->remove(articles);

        return $this;
    }
    public function eraseCredentials()
    {
        // nothing to do :)
    }
}