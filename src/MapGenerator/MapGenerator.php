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

namespace App\MapGenerator;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helpers\Navigator;
use App\Helpers\Factories\CellTypeFactory;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Map;
use App\MapGenerator\Algorithm\MapAlgorithm;
use Symfony\Component\Validator\Constraints as Assert;


class MapGenerator
{
    /**
     * @var string $name Map's name
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     *
     * @var MapAlgorithm
     */
    private $mapAlgorithm;

    /**
     *
     */
    public function __construct(Map $map = null)
    {
        ;
    }

    /**
     * Returns $mapAlgorithm
     *
     * @return Null|MapAlgorithm
     */
    public function getMapAlgorithm(): ?MapAlgorithm
    {
        return $this->mapAlgorithm;
    }

    /**
     *
     * @param MapAlgorithm $mapAlgorithm
     *
     * @return self
     */
    public function setMapAlgorithm(MapAlgorithm $mapAlgorithm): self
    {
        $this->mapAlgorithm = $mapAlgorithm;
    }


    /**
     * Generates and returns the map
     *
     * @return Map
     */
    public function generateMap(): Map
    {
        $this->mapAlgorithm->run();

        return $this->map = $this->mapAlgorithm->getMap();
    }
}
