<?php
namespace App\Helpers;

use App\Entity\Map;
use App\Entity\Cell;

/**
 * Class Navigator
 * 
 * @author PxlCtzn
 */
class Navigator
{
    /**
     * Returns an array of cells from the given map. 
     * The number of cells depends on the amount parameter. It's default value is 1
     * The random cells are choosen according to the {@see Navigator::getRandomCell()} function.
     * 
     * @param Map $map
     * @param int $amount
     * @param array $margin
     * @return \App\Entity\Cell[]
     */
    public static function getRandomCells(Map $map, int $amount = 1, array $margin=array('top' => 0, 'bottom' => 0, 'right' => 0, 'left' => 0), array $blacklistCellType = array())
    {
        $positions = array();
        
        $amount = $amount <= 0 ? 1 : $amount; // If amount is neg or zero, then it's 1
        
        
        do{
            $candidate = Navigator::getRandomCell($map, $margin); // We get some random cell from the map
            if(!in_array($candidate->getType(), $blacklistCellType)) 
                $positions[] = $candidate;
            
        }while(count($positions) < $amount); // ... until we reach the amount of position wanted
        
        return $positions;
    }
 
    /**
     * Returns a random cell in the given map according to the given margin identified by the following keys 'top', 'bottom', 'left' and 'right'. 
     * If no array is given then top=0, bottom=0, left=0 and right=0.
     * If a specific margin is not given then it's value equals 0.
     * 
     * Margin top and bottom must be between 0 and the map's height value -1
     * Margin left and right must be between 0 and the map's width value -1
     * 
     * @param Map $map
     * @param array $margin[top, right, bottom, left]
     */
    public static function getRandomCell(Map $map, array $margin = array())
    {
        // Check the margin parameter. 
        foreach(array('top', 'right', 'bottom', 'left') as $key)
        {
            if(!key_exists($key, $margin)) // If key does not exist
            {
                $margin[$key] = 0; // Then we set default value
            }
            // If the key exists we check its value
            elseif($margin[$key] < 0 // If the value is negative
                || (in_array($key, array('top',   'bottom'))   && $margin[$key] > $map->getHeight()-1) // Or if the key is either 'top' or 'bottom' AND the margin is greater than the map's height value -1 
                || (in_array($key, array('right', 'left'))     && $margin[$key] > $map->getWidth()-1)  // Or if the key is either 'right' or 'left' AND the margin is greater than the map's width value -1
                )
            {
                $margin[$key] = 0; // Then we set default value
            }
        }
        $cell = $map->getCell(
            random_int(0 + $margin['top'], // top border + margin
                $map->getHeight()-1 - $margin['bottom']),   // bottom (map height - 1) -margin
            random_int(0 + $margin['left'], // top border + margin
                $map->getWidth()-1 - $margin['right'])    // Random Column
        );
        
        return $cell;
    }
    /**
     * Returns an array containing the distance between the cell and the border in this order :
     *  - Top
     *  - Right
     *  - Bottom
     *  - Left
     *  
     * @param Map $map
     * @param Cell $cell
     * 
     * @return array
     */
    public static function getDistanceToBorder(Map $map, Cell $cell): array
    {
        return [
            'top'       => $cell->getY(),                       //Distance to the border on top
            'right'     => $map->getWidth()  -1 - $cell->getX(), //Distance to the border on the right
            'bottom'    => $map->getHeight() -1 - $cell->getY(), //Distance to the border on bottom
            'left'      => $cell->getX()];                      //Distance to the border on the left
    }
    
    /**
     * Returns the absolute distance between two cells as an array.
     * 
     * @param Cell $a
     * @param Cell $b
     *
     * @return array 
     */
    public static function getDistance(Cell $a, Cell $b): array
    {
        return [abs($a->getX() - $b->getX()), abs($a->getY() - $b->getY())];
    }
    
    /**
     * Returns the cell's left cell given in paramater.
     * If none found, null is return.
     * 
     * @param Map   $m
     * @param Cell  $c
     * @return Cell|NULL
     */
    public static function getLeftCell(Map $map, Cell $cell): ?Cell
    {
        $x = $cell->getX()-1;
        $y = $cell->getY();
        
        if($x >= $map->getWidth() || $x < 0)
            return null;
        
        return $map->getCell($y, $x); 
    }
    
    /**
     * Returns the cell's right cell given in paramater.
     * If none found, null is return.
     * 
     * @param Map $m
     * @param Cell $c
     * @return Cell|NULL
     */
    public static function getRightCell(Map $map, Cell $cell): ?Cell
    {
        $x = $cell->getX()+1;
        $y = $cell->getY();
        
        if($x >= $map->getWidth() || $x < 0)
            return null;
        
        return $map->getCell($y, $x); 
    }
    
    /**
     * Returns the cell's top cell given in paramater.
     * If none found, null is return.
     *
     * @param Map $m
     * @param Cell $c
     * @return Cell|NULL
     */
    public static function getTopCell(Map $map, Cell $cell): ?Cell
    {
        $x = $cell->getX();
        $y = $cell->getY()-1;
        
        if($y >= $map->getHeight() || $y < 0)
            return null;
            
        return $map->getCell($y, $x);
    }
    
    /**
     * Returns the cell's bottom cell given in paramater.
     * If none found, null is return.
     *
     * @param Map $m
     * @param Cell $c
     * @return Cell|NULL
     */
    public static function getBottomCell(Map $map, Cell $cell): ?Cell
    {
        $x = $cell->getX();
        $y = $cell->getY()+1;
        
        if($y >= $map->getHeight() || $y < 0)
            return null;
            
            return $map->getCell($y, $x);
    }
    
   
    /**
     * Returns the neighbors of the cell in an array
     * 
     * @param Map   $map
     * @param Cell  $cell
     * @param int   $radius
     * @return array
     */
    public static function getCellNeighbors(Map $map, Cell $cell,int $radius = 1): array
    {
        $neighbors = array();
        
        $lineStartIndex = ($cell->getY() - $radius) > 0 ? ($cell->getY() - $radius) : 0 ;
        $lineEndIndex   = ($cell->getY() + $radius) <= ($map->getHeight()-1) ? ($cell->getY() + $radius) : ($map->getHeight()-1) ;
        
        $columnStartIndex = ($cell->getX() - $radius) > 0 ? ($cell->getX() - $radius) : 0 ;
        $columnEndIndex   = ($cell->getX() + $radius) <= ($map->getWidth()-1) ? ($cell->getX() + $radius) : ($map->getWidth()-1) ;
        
        for($lineIndex = $lineStartIndex ; $lineIndex <= $lineEndIndex; $lineIndex++)
        {
            for($columnIndex = $columnStartIndex ; $columnIndex <= $columnEndIndex ; $columnIndex++)
            {
                if($lineIndex == $cell->getY() && $columnIndex == $cell->getX() ){
                        continue;
                }
                $neighbors[] = $map->getCell($lineIndex, $columnIndex);
            }
        }
        return $neighbors;
    }
}