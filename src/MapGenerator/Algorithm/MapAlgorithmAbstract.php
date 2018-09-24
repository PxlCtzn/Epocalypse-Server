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

namespace App\MapGenerator\Algorithm;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helpers\Navigator;
use App\Helpers\Factories\CellTypeFactory;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Map;
use App\Helpers\Generator\IslandNameGenerator;

/**
 * Class MapAlgorithmAbstract
 *
 * @author PxlCtzn
 *
 * @package App\Entity
 */
abstract class MapAlgorithmAbstract
{
    /**
     * Algorithm name
     *
     * @var string
     */
    protected $name;

    protected $map;

    public function __construct(String $name)
    {
        $this->name = $name;
        $this->mapName = IslandNameGenerator::generate();
        $map = new Map();
    }

    protected abstract function preprocessing();
    protected abstract function processing();
    protected abstract function postprocessing();

    /**
     *
     * @return self
     */
    public function run()
    {
        $this->preprocessing();
        $this->processing();
        $this->postprocessing();
    }

    /**
     * Returns $name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getClassname()
    {
        $class = new \ReflectionClass($this);
        return $class->getShortName();
    }
    /**
     * Returns $mapName
     *
     * @return string
     */
    public function getMapName(): string
    {
        return $this->mapName;
    }

    /**
     * Returns $mapWidth
     *
     * @return number
     */
    public function getMapWidth(): int
    {
        return $this->mapWidth;
    }

    /**
     * Returns $mapHeight
     *
     * @return number
     */
    public function getMapHeight(): int
    {
        return $this->mapHeight;
    }

    /**
     * @param string $mapName
     */
    public function setMapName(string $mapName)
    {
        $this->mapName = $mapName;

        return $this;
    }

    /**
     * @param int $mapWidth
     */
    public function setMapWidth(int $mapWidth)
    {
        $this->mapWidth = $mapWidth;
    }

    /**
     * @param int $mapHeight
     *
     * @return self
     */
    public function setMapHeight(int $mapHeight): self
    {
        $this->mapHeight = $mapHeight;

        return $this;
    }
}
