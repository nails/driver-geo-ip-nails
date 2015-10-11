<?php

namespace Nails\GeoIp\Driver;

class Nails implements \Nails\GeoIp\Interfaces\Driver
{
    /**
     * @param string $sIp  The IP address to look up
     * @return \Nails\GeoIp\Result\Ip
     */
    public function lookup($sIp)
    {
        $oResult = \Nails\Factory::factory('Ip', 'nailsapp/module-geo-ip');

        $oResult->setIp($sIp);
        $oResult->setHostname('The Hostname');
        $oResult->setCity('The City');
        $oResult->setRegion('The Region');
        $oResult->setCountry('The Country');
        $oResult->setLat('The Lat');
        $oResult->setLng('The Lng');

        return $oResult;
    }
}
