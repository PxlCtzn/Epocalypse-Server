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
namespace App\Controller\API;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;



use App\Entity\Cell;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MapGeneratorType;

/**
 * Class CellController
 *
 * @package App\Controller\API
 *
 * @Route("/map_generator", name="map_generator_")
 */
class MapGeneratorController extends FOSRestController
{
    private const NAMESPACE_TYPE = "App\\Form\\";
    private const NAMESPACE_DATA = "App\\MapGenerator\\Algorithm\\";
    /**
     * @param Cell $cell
     *
     * @Rest\Get(
     *     path = "/form/{name}",
     *     name = "get_form",
     *     options={"expose"=true}
     * )
     */
    public function getForm($name, $options = array()): View
    {
        $dataFQDN = self::NAMESPACE_DATA.$name;
        $typeFQDN = self::NAMESPACE_TYPE.$name."Type";

        if(class_exists($dataFQDN) && class_exits($typeFQDN))
        {
            $data = new $dataFQDN();
            $form =  $this->createForm($typeFQDN, $data, $options);


            return View::create(json_encode($this->get('liform')->transform($form)), Response::HTTP_OK);
        }
        else
        {
            return View::create(array("message" => "select an algorithm please !"), Response::HTTP_OK);
        }
    }

    public function transform()
    {
        $resolver = new Resolver();
        $resolver->setTransformer('text', Transformer\StringTransformer);
        $resolver->setTransformer('textarea', Transformer\StringTransformer, 'textarea');
        // more transformers you might need, for a complete list of what is used in Symfony
        // see https://github.com/Limenius/LiformBundle/blob/master/Resources/config/transformers.xml
        $liform = new Liform($resolver);

        $form = $this->createForm(CarType::class, $car, ['csrf_protection' => false]);
        $schema = json_encode($liform->transform($form));
    }
}
