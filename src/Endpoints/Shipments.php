<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Contracts\ShouldAuthenticate;
use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Shipment as ShipmentResource;
use Ramsey\Uuid\Uuid;

class Shipments extends BaseEndpoint implements ShouldAuthenticate
{
    /**
     * Create a new shipment for a parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Parcel  $parcel
     */
    public function create(Parcel $parcel)
    {
        $response = $this->performApiCall(
            'POST',
            'shipments',
            $this->getHttpBody($parcel)
        );

        return new ShipmentResource([
            'id' => $response->shipmentId,
            'barcode' => $response->pieces[0]->trackerCode,
            'label_id' => $response->pieces[0]->labelId,
        ]);
    }

    /**
     * Get the http body for the API request.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Parcel  $parcel
     * @return string
     */
    protected function getHttpBody(Parcel $parcel)
    {
        return json_encode(array_merge([
            'shipmentId' => Uuid::uuid4()->toString(),
            'accountId' => $this->apiClient->authentication->getAccessToken()->getAccountId(),
        ], $parcel->toArray()));
    }
}
