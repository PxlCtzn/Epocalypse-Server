<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Map;

class MapController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $map = new Map(150, 150, [], 60);
        
        return $this->render('map/index.html.twig', [
            'map' => $map,
            'size' => '5'
        ]);
    }
}
