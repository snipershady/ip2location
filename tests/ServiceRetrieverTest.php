<?php

namespace IpToLocation\Tests;

use IpToLocation\Service\IpInfoRetriever;
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
 * Description of ServiceRetrieverTest
 * @example ./vendor/phpunit/phpunit/phpunit --verbose tests/ServiceRetrieverTest.php 
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
class ServiceRetrieverTest extends AbstractTestCase {

//    public function testServiceIPv4DemoResponse(): void {
//        $ip = "173.194.67.94";
//        $serviceRetriever = new IpInfoRetriever();
//        var_dump($serviceRetriever->findInfoByIp($ip));
//        $this->assertTrue(true);
//    }


    public function testServiceIPv4(): void {
        $ip = "173.194.67.94";
        $serviceRetriever = new IpInfoRetriever();

        $this->assertEquals($ip, $serviceRetriever->findInfoByIp($ip)->getIp());
    }

    public function testServiceIPv6(): void {
        $ip = "2001:4860:4860::8888";
        $serviceRetriever = new IpInfoRetriever();

        $this->assertEquals($ip, $serviceRetriever->findInfoByIp($ip)->getIp());
    }

    public function testServiceEmptyStringIp(): void {
        $ip = "";
        $serviceRetriever = new IpInfoRetriever();
        $this->expectException(RuntimeException::class);
        $ipInfo = $serviceRetriever->findInfoByIp($ip);
    }

    public function testServiceNotValidIP(): void {
        $ip = "NotValidIp";
        $serviceRetriever = new IpInfoRetriever();
        $this->expectException(RuntimeException::class);
        $ipInfo = $serviceRetriever->findInfoByIp($ip);
    }

    public function testServiceLocalHost(): void {
        $ip = "127.0.0.1";
        $serviceRetriever = new IpInfoRetriever();
        $this->expectException(RuntimeException::class);
        $ipInfo = $serviceRetriever->findInfoByIp($ip);
    }

    public function testServicePrivateRangeIP(): void {
        $ip = "192.168.0.1";
        $serviceRetriever = new IpInfoRetriever();
        $this->expectException(RuntimeException::class);
        $ipInfo = $serviceRetriever->findInfoByIp($ip);
    }
}
