<?php
namespace App\Helpers;

use App\Entity\CellTypeEnum;
use App\Entity\CellType;

/**
 *
 * @author PxlCtzn
 *        
 */
class CellTypeFactory
{

    private static $CELL_TYPE_GENERATED = array();
    
    /**
     * Disable Contructor
     */
    private function __construct()
    {}
    
    /**
     * 
     * @param string $name
     * 
     * @return CellType|NULL
     */
    public static function createCellType(string $name): ?CellType
    {
        // If the candidate type is not valid
        if(!CellTypeEnum::isValidType($name))
        {
            var_dump("Type invalid '$name'");
            return null;
        }
        
        // If we have not instanciated this type yet, we do.
        if(!array_key_exists($name, self::$CELL_TYPE_GENERATED))
        {
            self::$CELL_TYPE_GENERATED[$name] = new CellType($name);
        }
        
        return self::$CELL_TYPE_GENERATED[$name];
    }
}

