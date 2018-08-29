<?php
namespace App\Controller;

use App\Entity\Map;
use App\Entity\Cell;

class Navigator
{
    
    /**
     * Returns an array containing the distance between the cell and the border in this order :
     *  - Top
     *  - Right
     *  - Bottom
     *  - Left
     *  
     * @param Map $m
     * @param Cell $c
     * 
     * @return array
     */
    public static function getDistanceToBorder(Map $m, Cell $c): array
    {
        return [$c->getX(), //Distance to the border on top
            $m->getWidth()-1  - $c->getY(), //Distance to the border on the right
            $m->getHeight()-1 - $c->getX(), //Distance to the border on bottom
            $c->getY()];    //Distance to the border on the left
    }
    
    /**
     * @param Cell $a
     * @param Cell $b
     *
     * @return array
     */
    public static function getDistance(Cell $a, Cell $b): array
    {
        return [abs($a->getX() - $b->getX()), abs($a->getY() - $b->getY())];
    }
    
    public static function getLeftCell(Map $m, Cell $c): ?Cell
    {
        $x = $c->getX()-1;
        $y = $c->getY();
        
        if($x >= $m->getWidth() || $x < 0)
            return null;
        
        return $m->getCell($y, $x); 
    }
    
    public static function getRightCell(Map $m, Cell $c): ?Cell
    {
        $x = $c->getX()+1;
        $y = $c->getY();
        
        if($x >= $m->getWidth() || $x < 0)
            return null;
        
        return $m->getCell($y, $x); 
    }
    
    public static function getTopCell(Map $m, Cell $c): ?Cell
    {
        $x = $c->getX();
        $y = $c->getY()-1;
        
        if($y >= $m->getHeight() || $y < 0)
            return null;
            
        return $m->getCell($y, $x);
    }
    
    public static function getBottomCell(Map $m, Cell $c): ?Cell
    {
        $x = $c->getX();
        $y = $c->getY()+1;
        
        if($y >= $m->getHeight() || $y < 0)
            return null;
            
        return $m->getCell($y, $x);
    }
    /**
     * Return the neighbor of the cell in an array
     * @param Map $m
     * @param Cell $c
     * @return array
     */
    public static function getCellNeighbors(Map $m, Cell $c, $radius = 1): array
    {
        $neighbors = array();
        for($line = $c->getY() - $radius ; $line <= ($c->getY()+ $radius); $line++){
            for($column = $c->getX() -$radius ; $column <= ($c->getX()+$radius) ; $column++){
                if($line < 0 || $line > $m->getHeight()-1 || $column < 0 || $column > $m->getWidth()-1 || $line == $c->getY() && $column == $c->getX() ){
                        continue;
                }
                $neighbors[] = $m->getCell($line, $column);
            }
        }
        return $neighbors;
    }
}