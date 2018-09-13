<?php
/**
 * This file is part of the Epocalypse-Server project.
 * 
 * Copyright (C) 2018  PxlCtzn
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or 
 * (at your option) any later version.
 *  
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <https://www.gnu.org/licenses/>.
 */
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
