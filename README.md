# ip2location
Free wrapper to easily implements ip2location.com free API


```bash
composer require snipershady/ip2location
```

```php
use IpToLocation\Service\IpInfoRetriever;


class fooClass(){
    public function getIpInfo(): \IpToLocation\Entity\IpInfo{
          $ipInfoRetriever = new \IpToLocation\Service\IpInfoRetriever();
          $ip = "8.8.8.8";
          return $ipInfoRetriever->findInfoByIp($ip);
    }
}
```

## Return Type


```php
IpToLocation\Entity\IpInfo {
  -ip: "1.1.1.1"
  -countryCode: "AU"
  -countryName: "Australia"
  -regionName: "Queensland"
  -cityName: "Brisbane"
  -latitude: "-27.46754"
  -longitude: "153.02809"
  -zipCode: "4000"
  -timeZone: "+10:00"
  -asn: "13335"
  -as: "CloudFlare Inc."
  -isProxy: false
  -message: "Limit to 500 queries per day. Sign up for a Free plan at https://www.ip2location.io to get 30K queries per month."
}
```