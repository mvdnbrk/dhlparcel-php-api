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

        return new ShipmentResource(array_merge([
            'id' => $response->shipmentId,
            'barcode' => $response->pieces[0]->trackerCode,
            'label_id' => $response->pieces[0]->labelId,
        ], $parcel->attributesToArray()));
    }

    /**
     * Get the http body for the API request.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Parcel  $parcel
     * @return string
     */
    protected function getHttpBody(Parcel $parcel)
    {
        return json_encode(
            collect([
                'shipmentId' => Uuid::uuid4()->toString(),
                'accountId' => $this->apiClient->authentication->getAccessToken()->getAccountId(),
            ])
            ->merge($parcel->toArray())
            ->all()
        );
    }
}
