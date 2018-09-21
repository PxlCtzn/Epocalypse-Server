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

/**
 * Class CellController
 *
 * @package App\Controller\API
 *
 * @Route("/cell", name="cell_")
 */
class CellController extends FOSRestController
{
    /**
     * @param Cell $cell
     *
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "get_info"
     * )
     */
    public function getCell(Cell $cell): View
    {
        return View::create($cell, Response::HTTP_OK);
    }
}
