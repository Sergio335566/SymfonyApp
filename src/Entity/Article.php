<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Article
{
    use EntityTrait;
    /**
     * @var string|null
     * @ORM\Column()
     * @Assert\Length (
     *      min = 2,
     *      max = 50
     * )
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     * @Assert\Length (
     *      min = 2,
     *      max = 5000
     * )
     */
    private $content;

    // ... getter and setter methods

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }


}