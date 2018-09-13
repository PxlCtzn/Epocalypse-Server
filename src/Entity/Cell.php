<?php
/**
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
use App\Helpers\Navigator;

/**
 * Class Cell
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CellRepository")
 * 
 * @namespace App\Entity
 * @author PxlCtzn
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
    
    private $renderBorderTop = false;
    private $renderBorderRight = false;
    private $renderBorderBottom = false;
    private $renderBorderLeft = false;

    /**
     * 
     * @param int $x
     * @param int $y
     * @param CellType $type
     * @param Map $m
     */
    public function __construct(int $x, int $y, CellType $type, Map $map)
    {
        $this->x = $x;
        $this->y = $y;
        
        $this->type = $type;
        $this->map  = $map;
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

    /**
     * 
     * @param CellType $type
     * @return self
     */
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
     * @return boolean
     */
    public function getRenderBorderTop()
    {
        return $this->renderBorderTop;
    }

    /**
     * @return boolean
     */
    public function getRenderBorderRight()
    {
        return $this->renderBorderRight;
    }

    /**
     * @return boolean
     */
    public function getRenderBorderBottom()
    {
        return $this->renderBorderBottom;
    }

    /**
     * @return boolean
     */
    public function getRenderBorderLeft()
    {
        return $this->renderBorderLeft;
    }

    /**
     * @param boolean $renderBorderTop
     */
    public function setRenderBorderTop($renderBorderTop):self
    {
        $this->renderBorderTop = $renderBorderTop;
        
        return $this;
    }

    /**
     * @param boolean $renderBorderRight
     */
    public function setRenderBorderRight($renderBorderRight):self
    {
        $this->renderBorderRight = $renderBorderRight;
        
        return $this;
    }

    /**
     * @param boolean $renderBorderBottom
     */
    public function setRenderBorderBottom($renderBorderBottom):self
    {
        $this->renderBorderBottom = $renderBorderBottom;
        
        return $this;
    }

    /**
     * @param boolean $renderBorderLeft
     */
    public function setRenderBorderLeft($renderBorderLeft):self
    {
        $this->renderBorderLeft = $renderBorderLeft;
        
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
    
    /*
    public function updateBorder(): self
    {
        if (!$this->isType(CellTypeEnum::PLAIN))
            return $this;
        
        $c = Navigator::getTopCell($this->map, $this);
        $this->renderBorderTop = ($c !== null && $c->isType(CellTypeEnum::WATER));
        
        $c = Navigator::getRightCell($this->map, $this);
        $this->renderBorderRight = ($c !== null && $c->isType(CellTypeEnum::WATER));
        
        $c = Navigator::getBottomCell($this->map, $this);
        $this->renderBorderBottom = ($c !== null && $c->isType(CellTypeEnum::WATER));
        
        $c = Navigator::getLeftCell($this->map, $this);
        $this->renderBorderLeft = ($c !== null && $c->isType(CellTypeEnum::WATER));
             
        return $this;
    }
    
    public function renderBorderClass():string
    {
        $str = "";
        if($this->renderBorderTop)
            $str .="borderTop ";
        if($this->renderBorderRight)
            $str .="borderRight ";
        if($this->renderBorderBottom)
            $str .="borderBottom ";
        if($this->renderBorderLeft)
            $str .="borderLeft";
        
        return $str;
    }
    */
        
        
    public function __toString(){
        return "Cell (x:".$this->x."; y: ".$this->y." ; type : ".$this->type->getName().")";
    }
}
