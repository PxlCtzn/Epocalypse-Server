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

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Timestampable\Traits\TimestampableEntity;

use App\Entity\Map;
use App\MapGenerator\Algorithm\MapAlgorithmAbstract;
use App\Helpers\Generator\IslandNameGenerator;
use App\Helpers\Navigator;
use App\Helpers\Factories\CellTypeFactory;


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
     * @var MapAlgorithmAbstract
     */
    private $mapAlgorithm;

    /**
     *
     */
    public function __construct()
    {
        $this->name = IslandNameGenerator::generate();
    }

    /**
     * Returns $mapAlgorithm
     *
     * @return Null|MapAlgorithmAbstract
     */
    public function getMapAlgorithm(): ?MapAlgorithmAbstract
    {
        return $this->mapAlgorithm;
    }

    /**
     *
     * @param MapAlgorithmAbstract $mapAlgorithm
     *
     * @return self
     */
    public function setMapAlgorithm(MapAlgorithmAbstract $mapAlgorithm): self
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
    /**
     * Returns $name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }



}
