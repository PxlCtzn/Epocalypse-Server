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
namespace App\Helpers\Generator;

/**
 * Class IslandNameGenerator
 * This class impletments the GeneratorInterface.
 *
 * The purpose of this class is to generate Island name on the go.
 * Simply call the IslandNameGenerator:generate() and you got yourself a random
 * island name.
 *
 * @author PxlCtzn
 *
 * @package App\Helpers\Generator
 */
class IslandNameGenerator implements GeneratorInterface
{
    private static $title = ["King", "Queen", "Melville", "Kangoroo", "Groote", "Fraser", "Cabbage Tree", "Green", "Kerguelen", "Turtle", "Pigeon", "Arthur", "Pendragon", "Merlin", "Guinevere"];
    private static $type   = ["Atoll", "Isle", "Archipelago", "Island", "Ait"];

    /**
     * Generate a random island name.
     *
     * @return string
     */
    public static function generate(): string
    {
        shuffle(self::$title);
        shuffle(self::$type);

        return sprintf("%s %s",
            self::$title[array_rand(self::$title)], // Getting a random Island title
            self::$type[array_rand(self::$type)]    // Getting a random Island type
        );
    }

}

