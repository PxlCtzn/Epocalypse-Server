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
namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Map;
use App\MapGenerator\MapGenerator;
use App\Form\MapGeneratorType;
use Symfony\Component\HttpFoundation\Request;
use App\MapGenerator\Algorithm\TestAlgorithmOne;
use App\MapGenerator\Algorithm\TestAlgorithmTwo;

/**
 * Class MapController
 *
 * @Route("/map", name="map_")
 *
 * @package App\Controller\Web
 */
class MapController extends AbstractController
{
    /**
     *
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
//         //$generator = new MapGenerator();

//         //$form = $this->createForm(MapGeneratorType::class, $generator);

//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {

//             $map = $generator->generateMap();

//             $entityManager = $this->getDoctrine()->getManager();
//             $entityManager->persist($map);
//             $entityManager->flush();

//             return $this->redirectToRoute('web_map_show', ['map' => $map]);
//         }
        return $this->render('map/create.html.twig', ['algorithms' => array (
            new TestAlgorithmOne(),
            new TestAlgorithmTwo(),
        )]); //'form' => $form->createView()
    }

    /**
     *
     * @Route("/list", name="list")
     */
    public function list()
    {
        $maps = $this->getDoctrine()->getRepository(Map::class)->findAll();

        return $this->render('map/list.html.twig', ['maps' => $maps]);
    }


    /**
     *
     * @Route("/show/{id}", name="show")
     */
    public function show(Map $map)
    {
        return $this->render('map/show.html.twig', ['map' => $map]);

    }


    /**
     *
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Map $map)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($map);
        $manager->flush();

        return $this->render('map/deleted.html.twig', ['map_id' => $map->getId()]);

    }
}
