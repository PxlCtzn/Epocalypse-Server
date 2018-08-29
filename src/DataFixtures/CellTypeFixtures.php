<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\CellType;

class CellTypeFixtures extends Fixture
{
    private $cellTypeNames = array("water", "field", "forest", "mountain", "desert");
    
    public function load(ObjectManager $manager)
    {
        foreach( $this->cellTypeNames as $name){
            $manager->persist(new CellType($name));
        }

        $manager->flush();
    }
    
    
}
