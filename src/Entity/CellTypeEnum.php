<?php
namespace App\Entity;


class CellTypeEnum
{
    public static $WATER    = "water";  
    public static $FIELD    = "field";
    public static $FOREST   = "forest";
    public static $DESERT   = "desert";    
    public static $MOUNTAIN = "mountain";    
    public static $UNKNOWN  = "unknown";    
    
    private function __construct(){
        
    }
}

