<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CellType
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CellTypeRepository")
 */
class CellType
{
    /**
     * @var int Unique ID
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Cell type name (ex: forest, town, tower...). This name must be unique. 
     * 
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    
    /**
     * 
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns CellType's id.
     * 
     * @return int|NULL
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the CellType's name
     * 
     * @return string|NULL
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /** 
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    
    public function __toString(): string
    {
        return $this->name;
    }
}
