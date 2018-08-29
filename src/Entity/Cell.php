<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CellRepository")
 */
class Cell
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CellType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Map", inversedBy="cells")
     * @ORM\JoinColumn(nullable=false)
     */
    private $map;

    public function __construct(int $x, int $y, CellType $type)
    {
        $this->x = $x;
        $this->y = $y;
        
        $this->type = $type;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getType(): ?CellType
    {
        return $this->type;
    }

    public function setType(?CellType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setMap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }
    
    /**
     * Returns true if the type of the cell is the same as the candidate,
     * else false.
     * 
     * @param CellType $candidate
     * @return bool
     */
    public function isType($candidate): bool
    {
        if($candidate instanceof CellType)
        {
            return $this->type->getName() === $candidate->getName();
        }elseif(is_string($candidate)){
            return $this->type->getName() === $candidate;
        }
        throw new \RuntimeException("Cell.isType() only accept CellType and String ! Given : ".gettype($candidate));
    }
}
