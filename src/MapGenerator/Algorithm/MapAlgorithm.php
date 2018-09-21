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

/**
 * Class BasicAlgorithm
 *
 *
 * @author PxlCtzn
 *
 * @package App\Entity
 */
abstract class MapAlgorithm
{
    /**
     * Algorithm name
     *
     * @var string
     */
    protected $name;

    protected $map;
    /**
     * Algorithm options
     * Array where each options is identified by a unique key
     *
     * @var array Algorithm options
     */
    protected $options;

    /**
     *
     * @var int
     */
    protected $mapWidth;

    /**
     *
     * @var int
     */
    protected $mapHeight;

    public function __construct(String $name)
    {
        $this->name = $name;
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
    /**
     * Returns $options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getClassname()
    {
        $class = new \ReflectionClass($this);
        return $class->getShortName();
    }
}