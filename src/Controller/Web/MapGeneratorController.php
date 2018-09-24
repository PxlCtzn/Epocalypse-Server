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

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

use App\Entity\Cell;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\MapAlgorithmAbstractType;
use App\MapGenerator\Algorithm\MapAlgorithmAbstract;
use Symfony\Component\Form\Form;

/**
 * Class CellController
 *
 * @package App\Controller\API
 *
 * @Route("/map_generator", name="map_generator_")
 */
class MapGeneratorController extends AbstractController
{

    private const NAMESPACE_TYPE = "App\\Form\\Algorithm\\";
    private const NAMESPACE_DATA = "App\\MapGenerator\\Algorithm\\";
    /**
     *
     * @Route(path = "/form/{name}", name = "get_form",  options={"expose"=true})
     */
    public function getForm(Request $request, $name): Response
    {
        if (empty((trim($name))))
        {
            throw new \RuntimeException("Can not get a form from an Empty Algorithm name.");
        }

        $mapAlgorithm     = $this->generateMapAlgorithmInstance($name);
        $mapAlgorithmForm = $this->generateMapAlgorithmFormInstance($name, $mapAlgorithm);

        if(null !== $mapAlgorithmForm && null !== $mapAlgorithmForm)
        {
            $response = $this->render('partials/map_algorithm_form.html.twig',
                [
                    "algorithm" => $mapAlgorithm,
                    "form"      => $mapAlgorithmForm->createView(),
                ]);

            if($request->isXmlHttpRequest()) // Si requete AJAX alors on encapsule la réponse dans du JSON
            {
                $response = new JsonResponse(array('form' => json_encode($response)));
            }

            return $response;
        }
    }

    private function generateMapAlgorithmInstance(string $mapAlgorithmName): ?MapAlgorithmAbstract
    {
        $mapAlgorithmFQDN = self::NAMESPACE_DATA.$mapAlgorithmName;

        return class_exists($mapAlgorithmFQDN) ?new $mapAlgorithmFQDN() : null;
    }

    private function generateMapAlgorithmFormInstance(string $mapAlgorithmName, MapAlgorithmAbstract $mapAlgorithm): ?Form
    {
        $mapAlgorithmTypeFQDN = self::NAMESPACE_TYPE.$mapAlgorithmName."Type";

        if(class_exists($mapAlgorithmTypeFQDN) && null !== $mapAlgorithm)
        {
            return $this->createForm($mapAlgorithmTypeFQDN, $mapAlgorithm,
                array(
                    'method' => 'POST' ,
                    'action' => $this->generateUrl("web_map_generator_generate_map"),
                    "attr"   => array(
                        "id" => "map_algorithm_form"
                    )
                )
            );
        }
        return null;
    }
    /**
     * This is the function called when the form is updated.
     *
     *
     *
     * @Route(path = "/generate", name = "generate_map",  options={"expose"=true})
     */
    public function generateMap(Request $request): Response
    {
        var_dump($request->request->all());


        return new Response("#");
    }
}
