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

namespace App\Helpers\Factories;

use App\Entity\CellTypeEnum;
use App\Entity\CellType;
use App\Entity\Map;

/**
 *
 * @author PxlCtzn
 *
 * @package App\Helpers\Factories
 */
class MapFactory
{

    /**
     * Disable public constructor
     */
    private function __construct()
    {}
    
    /**
     * 
     * @param string $name
     * 
     * @return Map
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

