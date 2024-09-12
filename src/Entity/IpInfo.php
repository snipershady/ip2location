<?php

namespace IpToLocation\Entity;

use Exception;
use RuntimeException;
use TypeIdentifier\Service\EffectivePrimitiveTypeIdentifierService;
use function array_key_exists;
use function json_decode;

class IpInfo {

    private string $ip;
    private string $countryCode;
    private string $countryName;
    private string $regionName;
    private string $cityName;
    private string $latitude;
    private string $longitude;
    private string $zipCode;
    private string $timeZone;
    private string $asn;
    private string $as;
    private bool $isProxy;
    private string $message;

    public function __construct(
            string $ip,
            string $countryCode,
            string $countryName,
            string $regionName,
            string $cityName,
            string $latitude,
            string $longitude,
            string $zipCode,
            string $timeZone,
            string $asn,
            string $as,
            bool $isProxy,
            string $message
    ) {
        $this->ip = $ip;
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->regionName = $regionName;
        $this->cityName = $cityName;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->zipCode = $zipCode;
        $this->timeZone = $timeZone;
        $this->asn = $asn;
        $this->as = $as;
        $this->isProxy = $isProxy;
        $this->message = $message;
    }

    /**
     * 
     * @param string $json
     * @return self
     * @throws RuntimeException
     */
    public static function unserialize(string $json): self {
        $epti = new EffectivePrimitiveTypeIdentifierService();
        try {
            $data = json_decode($json, true, 512, JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
        if (array_key_exists("error", $data)) {
            throw new RuntimeException((string) $epti->getTypedValueFromArray("error_message", $data["error"], true, true));
        }

        if (empty($epti->getTypedValueFromArray("city_name", $data, true, true))) {
            throw new RuntimeException("this is local or private ip address");
        }

        return new self(
                $epti->getTypedValueFromArray("ip", $data, true, true),
                $epti->getTypedValueFromArray("country_code", $data, true, true),
                $epti->getTypedValueFromArray("country_name", $data, true, true),
                $epti->getTypedValueFromArray("region_name", $data, true, true),
                $epti->getTypedValueFromArray("city_name", $data, true, true),
                $epti->getTypedValueFromArray("latitude", $data, true, true),
                $epti->getTypedValueFromArray("longitude", $data, true, true),
                $epti->getTypedValueFromArray("zip_code", $data, true, true),
                $epti->getTypedValueFromArray("time_zone", $data, true, true),
                $epti->getTypedValueFromArray("asn", $data, true, true),
                $epti->getTypedValueFromArray("as", $data, true, true),
                $epti->getTypedValueFromArray("is_proxy", $data),
                $epti->getTypedValueFromArray("message", $data, true, true),
        );
    }

    public function serialize(): ?string {
        $arrayObject = [
            'ip' => $this->getIp(),
            'country_code' => $this->getCountryCode(),
            'country_name' => $this->getCountryName(),
            'region_name' => $this->getRegionName(),
            'city_name' => $this->getCityName(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'zip_code' => $this->getZipCode(),
            'time_zone' => $this->getTimeZone(),
            'asn' => $this->getAsn(),
            'as' => $this->getAs(),
            'is_proxy' => $this->getIsProxy(),
            'message' => $this->getMessage()
        ];

        $resultString = json_encode($arrayObject, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
        return !empty($resultString) ? $resultString : null;
    }

    public function getIp(): string {
        return $this->ip;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function getCountryName(): string {
        return $this->countryName;
    }

    public function getRegionName(): string {
        return $this->regionName;
    }

    public function getCityName(): string {
        return $this->cityName;
    }

    public function getLatitude(): string {
        return $this->latitude;
    }

    public function getLongitude(): string {
        return $this->longitude;
    }

    public function getZipCode(): string {
        return $this->zipCode;
    }

    public function getTimeZone(): string {
        return $this->timeZone;
    }

    public function getAsn(): string {
        return $this->asn;
    }

    public function getAs(): string {
        return $this->as;
    }

    public function getIsProxy(): bool {
        return $this->isProxy;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function setIp(string $ip): self {
        $this->ip = $ip;
        return $this;
    }

    public function setCountryCode(string $countryCode): self {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function setCountryName(string $countryName): self {
        $this->countryName = $countryName;
        return $this;
    }

    public function setRegionName(string $regionName): self {
        $this->regionName = $regionName;
        return $this;
    }

    public function setCityName(string $cityName): self {
        $this->cityName = $cityName;
        return $this;
    }

    public function setLatitude(string $latitude): self {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude(string $longitude): self {
        $this->longitude = $longitude;
        return $this;
    }

    public function setZipCode(string $zipCode): self {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function setTimeZone(string $timeZone): self {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function setAsn(string $asn): self {
        $this->asn = $asn;
        return $this;
    }

    public function setAs(string $as): self {
        $this->as = $as;
        return $this;
    }

    public function setIsProxy(bool $isProxy): self {
        $this->isProxy = $isProxy;
        return $this;
    }

    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }
}
