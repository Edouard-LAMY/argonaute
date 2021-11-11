<?php

namespace App\Entity;

use App\Repository\ArgonauteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArgonauteRepository::class)
 */
class Argonaute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+",
     *     message="Pas de caractères spéciaux autorisés"
     * )
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Merci de rentrer plus de 2 caractères",
     *      maxMessage = "Merci de rentrer moins de 25 caractères"
     * )
     */

    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        $this->name;
    }
}
