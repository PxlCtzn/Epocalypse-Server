<?php
namespace App\Entity;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\Navigator;
/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\MapRepository")
 */
class Map
{
    /**
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $width;
    
    /**
     *
     * @ORM\Column(type="integer")
     */
    private $height;
    
    private $seaBorderWidth;
    



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cell", mappedBy="map", orphanRemoval=true)
     */
    private $cells;

    private $mountains = array();
    
    private $forests = array();
    
    public function __construct(int $width, int $height, array $mountainPositions=array(),  int $seaBorderWidth=1 )
    {
        $this->width    = $width;
        $this->height   = $height;

        $this->seaBorderWidth = $seaBorderWidth;
        
        $this->cells = array();
        
        for($l = 0 ; $l < $height; $l++){
            for($c = 0 ; $c < $width; $c++){
                $this->cells[$l][$c] = new Cell($c, $l, new CellType(CellTypeEnum::$UNKNOWN));
            }
        }
        
        // We place the border
        $this->createSeaBorder(1);
        
        // We put the mountains
        $this->createMountains();
        
        // We put the mountains
        $this->checkForests();
        
        // We complete the map
        $this->paintMap();
    }

    /**
     * Generates the sea border
     * 
     * @param int $borderWidth
     */
    private function createSeaBorder(int $borderWidth = 1)
    {
        /**
         * If Border is too small (<1) or too big (bigger than height or width)
         * Then reset to default value
         */
        if($borderWidth < 1 || $borderWidth > $this->height || $borderWidth > $this->width)
            $borderWidth = 1;
        
        // Top & bottom
        for($line = 0 ; $line < $this->height; $line++ ) 
        {
            for( $column = 0; $column < $this->width; $column++ )
            {
                if ($line >= $borderWidth && $line < $this->height - $borderWidth && $column >= $borderWidth && $column < $this->width - $borderWidth)
                {
                    continue;
                }
                $this->cells[$line][$column] = new Cell($column, $line, new CellType(CellTypeEnum::$WATER));
            }
        }
        
    }
    
    private function createMountains(array $positions = array())
    {
        if(empty($positions))
        {
              $positions = array();
              $iterations = 5; // Number of mountain we want to generate
              for($i = 0; $i < $iterations; $i++){
                  $positions[] = $this->getCell(
                      random_int($this->seaBorderWidth, $this->getHeight()-$this->getSeaBorderWidth()-1),   // Random Line
                      random_int($this->seaBorderWidth, $this->getWidth()-$this->getSeaBorderWidth()-1)     // Random Column
                      );
              }
        }
        $this->mountains = $positions;
        /**
         * @var Cell $cell
         */
        foreach($this->mountains as $cell)
        {
            $cell->setType(new CellType(CellTypeEnum::$MOUNTAIN));
            
            $neigbhors = Navigator::getCellNeighbors($this, $cell);
            
            foreach($neigbhors as $neigbhorCell)
            {
                if($neigbhorCell->isType(CellTypeEnum::$WATER) || $neigbhorCell->isType(CellTypeEnum::$MOUNTAIN)){
                    continue;
                }
                $this->forests[] = $neigbhorCell->setType(new CellType(CellTypeEnum::$FOREST));
            }
            
        }
    }
    
    private function checkForests(): void
    {
        $rebake = false;
        do{
            $rebake = false;
            
            // Top & bottom
            for($line = 0 ; $line < $this->height; $line++ )
            {
                for( $column = 0; $column < $this->width; $column++ )
                {
                    /**
                     * @var Cell $c
                     */
                    $c = $this->cells[$line][$column];
                    if($c->isType(CellTypeEnum::$UNKNOWN))
                    {
                        $top    = Navigator::getTopCell($this, $c);
                        $bottom = Navigator::getBottomCell($this, $c);
                        $left   = Navigator::getLeftCell($this, $c);
                        $right  = Navigator::getRightCell($this, $c);
                        
                        if((!is_null($top) && !is_null($bottom) && 
                            $top->isType(CellTypeEnum::$FOREST) && $bottom->isType(CellTypeEnum::$FOREST))||
                            (!is_null($left) && !is_null($right) &&
                                $left->isType(CellTypeEnum::$FOREST) && $right->isType(CellTypeEnum::$FOREST)))
                        {
                            $rebake = true;
                            $c->setType(new CellType(CellTypeEnum::$FOREST));
                            continue;
                        }
                    }
                    
                }
            }
        }while($rebake);
    }
    
    private function paintMap()
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
                if($cell->isType(CellTypeEnum::$UNKNOWN)){
                    
                }
                //$this->cells[$line][$column] = new Cell($column, $line, new CellType(CellTypeEnum::$WATER));
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

    public function getCell( int $line, int $column): Cell
    {
        return $this->cells[$line][$column];
    }
    /**
     * @return integer
     */
    public function getSeaBorderWidth()
    {
        return $this->seaBorderWidth;
    }

    /**
     * @return Collection|Cell[]
     */
    public function getCells(): Collection
    {
        return $this->cells;
    }

    
    /**
     * @return Ambigous <multitype:, multitype:\App\Entity\Cell >
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

}
