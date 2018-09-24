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
use App\MapGenerator\Algorithm\MapAlgorithmAbstract;
use App\Entity\Cell;
use App\Entity\CellTypeEnum;
use App\Entity\CellType;

/**
 * Class Map
 *
 *
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 *
 * @author PxlCtzn
 *
 * @package App\Entity
 */
class BasicAlgorithm extends MapAlgorithmAbstract
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var int Thickness of the sea at the edge of the map.
     */
    private $seaThickness;

    private $waters = array();

    /**
     * @var array
     */
    private $mountains = array();

    /**
     * @var array
     */
    private $forests = array();

    public function __construct(int $width, int $height, array $mountainPositions=array(),  int $seaThickness=1 )
    {
        parent::__construct("Basic Algorithm");

        $this->width    = $width;
        $this->height   = $height;

        $this->seaThickness = $seaThickness;
    }

    /**
     * Initiates the map by setting all its cell with the CellTypeEnum::UNKNOWN type.
     *
     * @return self
     */
    private function initiateMap(): self
    {
        $this->cells = array();

        for($l = 0 ; $l < $this->height; $l++){
            for($c = 0 ; $c < $this->width; $c++){
                    $this->cells[$l][$c] = new Cell($c, $l, CellTypeFactory::createCellType(CellTypeEnum::UNKNOWN), $this);
            }
        }

        return $this;
    }

    /**
     * Generates the sea border
     *
     * @param int $borderThickness
     * @param int $spread
     */
    private function createSeaBorder(int $spread=0)
    {
        $spread = ($spread < 0) ? 0 : $spread;

        for($line = 0 ; $line < $this->height; $line++ ) // For every line ...
        {
            for( $column = 0; $column < $this->width; $column++ ) // ... in every column ...
            {
                /** @var Cell $cell */
                $currentCell = $this->cells[$line][$column]; // ... we get the current cell.
                $distances = Navigator::getDistanceToBorder($this, $currentCell); // We get the distance from the cell to the four edge.
                $minDistance = min($distances);
                $pourcentage = (int) (100*(log(1-($minDistance)/($this->seaThickness+$spread))+1));
                $luck = mt_rand(0,99);

                if($luck < $pourcentage)
                {
                    $this->waters[] = $currentCell->setType(CellTypeFactory::createCellType(CellTypeEnum::WATER));
                }

            }
        }

        $this->createBeach();
    }

    /**
     *
     */
    private function createBeach()
    {
        /** @var Cell $waterCell */
        foreach($this->waters as $waterCell) // For each water cell ...
        {
            $neighbors = Navigator::getCellNeighbors($this, $waterCell); // ... we get its neighbors ...

            foreach($neighbors as $neighbor) // and for each neighbor ...
            {
                if($neighbor->isType(CellTypeEnum::UNKNOWN)) // ... if it's type is UNKNOWN ...
                {
                    $neighbor->setType(CellTypeFactory::createCellType(CellTypeEnum::PLAIN)); // ... we set it to PLAIN.
                }
            }
        }
    }

    /**
     * Generate mountains and modify its neighbors according to specific rules.
     * If no mountain position is given, then we generate some according to the iteration parameter (default value 25).
     *
     * @param array $positions
     * @param int $iterations
     */
    private function createMountains(array $positions = array(), int $iterations = 25)
    {
        if(empty($positions)) // If no positions given ...
        {
            $iterations     = ($iterations < 0) ? 25 : $iterations; // ... we check the $iterations value (i.e: If iterations value is below 0, then get default value) ...
            $margin         = array('top' => $this->seaThickness, 'right' => $this->seaThickness, 'bottom' => $this->seaThickness, 'left' =>$this->seaThickness);
            $positions      = Navigator::getRandomCells($this, $iterations, $margin, array(CellTypeEnum::PLAIN, CellTypeEnum::WATER)); // ... we get some from the map.
        }

        $this->mountains = $positions;

        /** @var Cell $cell */
        foreach($this->mountains as $cell) // For each cell ...
        {
            $cell->setType(CellTypeFactory::createCellType(CellTypeEnum::MOUNTAIN)); // ... we set its type to MOUNTAIN
        }
        $this->updateCellTypeIfBetweenTwoSameCellType(CellTypeEnum::UNKNOWN, array(CellTypeEnum::UNKNOWN, CellTypeEnum::WATER)); // If 2 MOUNTAIN are separeted by one UNKNOW CELL, then this UNKNOW CELL is set to MOUNTAIN. We don't want to change WATER AND U

        // and update the neighbors
        $this->setTypeCellsNeighbors( $this->mountains, CellTypeFactory::createCellType(CellTypeEnum::FOREST), array(CellTypeEnum::WATER, CellTypeEnum::MOUNTAIN, CellTypeEnum::PLAIN) );
        $this->updateCellTypeIfBetweenTwoSameCellType(CellTypeEnum::UNKNOWN, array(CellTypeEnum::UNKNOWN, CellTypeEnum::WATER, CellTypeEnum::MOUNTAIN));

    }

    /**
     * Set the type of the neighbors of the cell given in parameter
     * to the CellType specified unless the neighbor's type is in the given array.
     *
     * @param array     $cells          The cell we want to update the neighbors of.
     * @param CellType  $newType        The cell type we want to use for the neighbors
     * @param array     $typeExceptions The types that must stay unchange
     * @param int       $radius         The radius of the neighborhood
     *
     * @return self
     */
    private function setTypeCellsNeighbors(array $cells, CellType $newType,  array $cellTypeExceptions = array(CellTypeEnum::WATER), int $radius=1): self
    {
        $radius = ($radius < 1) ? 1: $radius; // If $radius value is neg. or zero, then get default value

        /**
         * @var Cell $cell
         */
        foreach($cells as $cell) // For each cell ...
        {

            $neighbors = Navigator::getCellNeighbors($this, $cell); // ... we get its neighbors ...

            foreach($neighbors as $neighbor) // ... and for each of the neighbors ...
            {
                if(in_array($neighbor->getType()->getName(), $cellTypeExceptions)) // ... if the neighbor's type is in the Exception list ...
                {
                    continue; // ... we skip it.
                }
                $this->forests[] = $neighbor->setType($newType); // ... else we set the neighbor type to FOREST and save it for later (checkForest())
            }

        }

        return $this;
    }


    /**
     * Scans the map AND
     * IF a cell's type is equals to the one given AND
     * both of EITHER top AND bottom OR left AND right cells have the same type AND
     * the type of the couple of cells is not blacklisted
     * THEN the cell's type is update with the one of its neigbors.
     *
     * Priority is given to the top and bottom (i.e: if top's type == bottom's type then the right and left cells are ignored).
     *
     * @return self
     */
    private function updateCellTypeIfBetweenTwoSameCellType(string $cellType, array $blacklistCellType = array()): self
    {
        do{
            $rebake = false; //

            for($line = 0 ; $line < $this->height; $line++ )
            {
                for( $column = 0; $column < $this->width; $column++ )
                {
                    /** @var Cell $currentCell */
                    $currentCell = $this->cells[$line][$column];

                    if($currentCell->isType($cellType))
                    {
                        $top    = Navigator::getTopCell($this,      $currentCell);
                        $bottom = Navigator::getBottomCell($this,   $currentCell);

                        $left   = Navigator::getLeftCell($this,     $currentCell);
                        $right  = Navigator::getRightCell($this,    $currentCell);

                        if(!is_null($top) && !is_null($bottom) && $top->isType($bottom->getType()) && !in_array($top->getType(), $blacklistCellType))
                        {
                            $rebake = true;
                            $currentCell->setType($top->getType());
                            continue;
                        }
                        elseif(!is_null($left) && !is_null($right) && $left->isType($right->getType()) && !in_array($left->getType(), $blacklistCellType))
                        {
                            $rebake = true;
                            $currentCell->setType($right->getType());
                            continue;
                        }
                    }

                }
            }
        }while($rebake);

        return $this;
    }


    private function createDeserts()
    {
        for($line = 0 ; $line < $this->height; $line++ )
        {
            for( $column = 0; $column < $this->width; $column++ )
            {
                /**
                 *
                 * @var Cell $cell
                 */
                $cell = $this->cells[$line][$column];
                if($cell->isType(CellTypeEnum::UNKNOWN)){
                    $this->cells[$line][$column]->setType(new CellType(CellTypeEnum::DESERT));
                }
                //
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Returns a the cell on the given line and column.
     *
     * @param int $line     Index of the line
     * @param int $column   Index of the column
     * @return Cell
     */
    public function getCell( int $line, int $column): Cell
    {
        return $this->cells[$line][$column];
    }

    /**
     * @return integer
     */
    public function getSeaThickness()
    {
        return $this->seaThickness;
    }

    /**
     * @return Collection|Cell[]
     */
    public function getCells(): Collection
    {
        return $this->cells;
    }


    /**
     * @return Cell[]
     */
    public function getMountains()
    {
        return $this->mountains;
    }

    public function addCell(Cell $cell): self
    {
        if (!$this->cells->contains($cell)) {
            $this->cells[] = $cell;
            $cell->setMap($this);
        }

        return $this;
    }

    public function removeCell(Cell $cell): self
    {
        if ($this->cells->contains($cell)) {
            $this->cells->removeElement($cell);
            // set the owning side to null (unless already changed)
            if ($cell->getMap() === $this) {
                $cell->setMap(null);
            }
        }

        return $this;
    }


    protected function preprocessing(): self
    {
        // Fills the map with unknown cells
        $this->initiateMap();

        return $this;
    }

    protected function processing(): self
    {
        // We place the border (which will also create the plain)
        $this->createSeaBorder();

        // We put the mountains (which will also create the forest)
        $this->createMountains();

        // We will also create the forest
        $this->createDeserts();

        return $this;
    }


    protected function postprocessing(): self
    {
        return $this;
    }

}
