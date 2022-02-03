<?php

namespace App\Entity;

use App\Repository\WishMovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WishMovieRepository::class)
 */
class WishMovie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTheMovieDb;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

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

    public function getIdTheMovieDb(): ?int
    {
        return $this->idTheMovieDb;
    }

    public function setIdTheMovieDb(int $idTheMovieDb): self
    {
        $this->idTheMovieDb = $idTheMovieDb;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }
}
