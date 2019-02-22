<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Shipment;

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
     * @param  \Mvdnbrk\MyParcel\Resources\Shipment|string  $value
     * @return string
     */
    public function get($value)
    {
        if ($value instanceof Shipment) {
            $value = $value->label_id;
        }

        $response = $this->performApiCall(
            'GET',
            'labels/'.$value,
            null,
            ['Accept' => 'application/pdf']
        );

        return $response;
    }
}
