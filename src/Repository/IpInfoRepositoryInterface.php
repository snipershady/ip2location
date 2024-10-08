<?php

namespace IpToLocation\Repository;

use IpToLocation\Entity\IpInfo;
use InvalidArgumentException;
use RuntimeException;

/*
 * Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of IpInfoRepositoryInterface
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
interface IpInfoRepositoryInterface {

    /**
     * 
     * @param string $ip
     * @param string|null $apikey
     * @return IpInfo
     * @throws InvalidArgumentException|RuntimeException
     */
    public function findByIp(string $ip, ?string $apikey = null): IpInfo;
}
