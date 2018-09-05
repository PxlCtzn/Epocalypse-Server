<?php
namespace App\Entity;

/**
 * Class CellTypeEnum
 * 
 * @author PxlCtzn
 */
class CellTypeEnum
{
    public const WATER    = "water";  
    public const PLAIN    = "plain";
    public const FOREST   = "forest";
    public const DESERT   = "desert";    
    public const MOUNTAIN = "mountain";    
    public const UNKNOWN  = "unknown";    

    /**
     * Disables public constructor
     */
    private function __construct(){
    }
    
    /**
     * If the $candidate type is valid returns true,
     * Else false.
     * 
     * @param string $candidate
     * 
     * @return boolean true if valid, else false.
     */
    public static function isValidType(string $candidate)
    {
        switch ($candidate)
        { // TODO Dirty as fuck
            case self::WATER:
            case self::PLAIN:
            case self::FOREST:
            case self::DESERT:
            case self::MOUNTAIN:
            case self::UNKNOWN:
                return true;
            default:
                return false;
        }
    }
}

