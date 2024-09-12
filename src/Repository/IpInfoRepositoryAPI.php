<?php

namespace IpToLocation\Repository;

use IpToLocation\Entity\IpInfo;
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
 * Description of IpInfoRepositoryAPI
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
final class IpInfoRepositoryAPI implements IpInfoRepositoryInterface {

    private string $entrypoint = "https://api.ip2location.io/";

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function findByIp(string $ip, ?string $apikey = null): IpInfo {
        $qs = "?ip=$ip&format=json";
        if (!empty($apikey)) {
            $qs .= "&key=$apikey";
        }

        $url = $this->entrypoint . $qs;
        $ipInfo = IpInfo::unserialize($this->httpRequest($url));

        return $ipInfo;
    }

    /**
     * 
     * @param string $url
     * @return string
     * @throws RuntimeException
     */
    private function httpRequest(string $url): string {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);
        if ($response === false) {
            throw new RuntimeException("Fail: " . curl_error($curl));
        }

        curl_close($curl);

        return (string) $response;
    }
}
