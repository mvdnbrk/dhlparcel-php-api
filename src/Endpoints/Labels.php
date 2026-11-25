<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Contracts\ShouldAuthenticate;
use Mvdnbrk\DhlParcel\Resources\Shipment;

class Labels extends BaseEndpoint implements ShouldAuthenticate
{
    /**
     * Get a shipment label by shipment id.
     *
     * @return string
     */
    public function get(Shipment|string $value)
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
