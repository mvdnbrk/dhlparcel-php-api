<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

class Labels extends BaseEndpoint
{
    /**
     * Indicates if this endpoint needs authentication.
     *
     * @var bool
     */
    protected $mustAuthenticate = true;

    /**
     * Get a shipment label by shipment id.
     *
     * @param string $labelId
     * @return string
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function get(string $labelId)
    {
        $response = $this->performApiCall(
            'GET',
            'labels/'.$labelId,
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }
}
