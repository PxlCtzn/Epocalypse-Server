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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TestAlgorithmTwo
 *
 *
 * @author PxlCtzn
 *
 * @package App\Entity
 */
class TestAlgorithmTwo extends MapAlgorithm
{

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     *
     * @ORM\Column(type="integer")
     */
    private $seaWidth;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     *
     * @ORM\Column(type="integer")
     */
    private $elevation;

    public function __construct()
    {
        parent::__construct("Algorithm Two");
    }


    public function postprocessing()
    {}

    public function preprocessing()
    {}

    public function processing()
    {}
    /**
     * Returns $seaWidth
     *
     * @return mixed
     */
    public function getSeaWidth()
    {
        return $this->seaWidth;
    }

    /**
     * @param mixed $seaWidth
     */
    public function setSeaWidth($seaWidth)
    {
        $this->seaWidth = $seaWidth;
    }

    /**
     * Returns $elevation
     *
     * @return mixed
     */
    public function getElevation()
    {
        return $this->elevation;
    }

    /**
     * @param mixed $elevation
     */
    public function setElevation($elevation)
    {
        $this->elevation = $elevation;
    }

}
