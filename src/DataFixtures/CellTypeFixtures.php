<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\CellType;
use App\Entity\CellTypeEnum;

class CellTypeFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        $cellTypeNames = array(CellTypeEnum::$DESERT, 
            CellTypeEnum::$FOREST,
            CellTypeEnum::$MOUNTAIN,
            CellTypeEnum::$PLAIN,
            CellTypeEnum::$UNKNOWN,
            CellTypeEnum::$WATER,
            );
        foreach( $this->cellTypeNames as $name){
            $manager->persist(new CellType($name));
        }

        $manager->flush();
    }
    
    
}
