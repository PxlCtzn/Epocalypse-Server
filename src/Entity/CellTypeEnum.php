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

