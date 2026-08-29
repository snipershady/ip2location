<?php

declare(strict_types=1);

namespace IpToLocation\Entity;

use TypeIdentifier\Service\EffectivePrimitiveTypeIdentifierService;

final readonly class IpInfo
{
    public function __construct(private string $ip, private string $countryCode, private string $countryName, private string $regionName, private string $cityName, private string $latitude, private string $longitude, private string $zipCode, private string $timeZone, private string $asn, private string $as, private bool $isProxy, private string $message)
    {
    }

    /**
     * @throws \RuntimeException
     */
    public static function unserialize(string $json): self
    {
        $epti = new EffectivePrimitiveTypeIdentifierService();
        try {
            $data = \json_decode($json, associative: true, depth: 512, flags: JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);
        } catch (\JsonException $jsonException) {
            throw new \RuntimeException($jsonException->getMessage(), $jsonException->getCode(), $jsonException);
        }

        if (!\is_array($data)) {
            throw new \RuntimeException('Unexpected API response: a JSON object was expected');
        }

        if (\array_key_exists('error', $data)) {
            $error = $data['error'];
            throw new \RuntimeException($epti->getStringValueFromArray('error_message', \is_array($error) ? $error : null, trim: true, forceString: true));
        }

        if ('' === $epti->getStringValueFromArray('city_name', $data, trim: true, forceString: true)) {
            throw new \RuntimeException('this is local or private ip address');
        }

        return new self(
            $epti->getStringValueFromArray('ip', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('country_code', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('country_name', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('region_name', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('city_name', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('latitude', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('longitude', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('zip_code', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('time_zone', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('asn', $data, trim: true, forceString: true),
            $epti->getStringValueFromArray('as', $data, trim: true, forceString: true),
            $epti->getBoolValueFromArray('is_proxy', $data),
            $epti->getStringValueFromArray('message', $data, trim: true, forceString: true),
        );
    }

    public function serialize(): string
    {
        $arrayObject = [
            'ip' => $this->ip,
            'country_code' => $this->countryCode,
            'country_name' => $this->countryName,
            'region_name' => $this->regionName,
            'city_name' => $this->cityName,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'zip_code' => $this->zipCode,
            'time_zone' => $this->timeZone,
            'asn' => $this->asn,
            'as' => $this->as,
            'is_proxy' => $this->isProxy,
            'message' => $this->message,
        ];

        return json_encode($arrayObject, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function getRegionName(): string
    {
        return $this->regionName;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function getAsn(): string
    {
        return $this->asn;
    }

    public function getAs(): string
    {
        return $this->as;
    }

    public function getIsProxy(): bool
    {
        return $this->isProxy;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
