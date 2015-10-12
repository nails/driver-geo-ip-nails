<?php

namespace Nails\GeoIp\Driver;

class Nails implements \Nails\GeoIp\Interfaces\Driver
{
    /**
     * The base url of the ipinfo.io service.
     * @var string
     */
    const BASE_URL = 'http://ipinfo.io';

    // --------------------------------------------------------------------------

    /**
     * The access token for the ipinfo.io service
     * @var string
     */
    private $sAccessToken;

    // --------------------------------------------------------------------------

    /**
     * Construct the driver
     */
    public function __construct()
    {
        $this->sAccessToken = defined('APP_GEO_IP_ACCESS_TOKEN') ? APP_GEO_IP_ACCESS_TOKEN : '';
    }

    // --------------------------------------------------------------------------

    /**
     * @param string $sIp  The IP address to look up
     * @return \Nails\GeoIp\Result\Ip
     */
    public function lookup($sIp)
    {
        $oIp     = \Nails\Factory::factory('Ip', 'nailsapp/module-geo-ip');
        $oClient = \Nails\Factory::factory('HttpClient');

        $oIp->setIp($sIp);

        try {

            $oResponse = $oClient->get(
                $this::BASE_URL . '/' . $sIp . '/json',
                array(
                    'token' => $this->sAccessToken
                )
            );

            if ($oResponse->getStatusCode() === 200) {

                $oJson = json_decode($oResponse->getBody());

                if (!empty($oJson->hostname)) {

                    $oIp->setHostname($oJson->hostname);
                }

                if (!empty($oJson->city)) {

                    $oIp->setCity($oJson->city);
                }

                if (!empty($oJson->region)) {

                    $oIp->setRegion($oJson->region);
                }

                if (!empty($oJson->country)) {

                    $oIp->setCountry($oJson->country);
                }

                if (!empty($oJson->loc)) {

                    $aLatLng = explode(',', $oJson->loc);

                    if (!empty($aLatLng[0])) {

                        $oIp->setLat($aLatLng[0]);
                    }

                    if (!empty($aLatLng[1])) {

                        $oIp->setLng($aLatLng[1]);
                    }
                }
            }

        } catch (\Exception $e) {
            //  @log the exception somewhere
        }

        return $oIp;
    }
}
