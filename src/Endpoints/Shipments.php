<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Parcel;
use Mvdnbrk\DhlParcel\Resources\Shipment as ShipmentResource;
use Mvdnbrk\DhlParcel\Resources\ShipmentPiece;
use Ramsey\Uuid\Uuid;
use stdClass;

class Shipments extends BaseEndpoint
{
    /**
     * Indicates if this endpoint needs authentication.
     *
     * @var bool
     */
    protected $mustAuthenticate = true;

    /**
     * Create a new shipment for a parcel.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Parcel $parcel
     * @return ShipmentResource
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
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
            'pieces' => collect($response->pieces)
                ->map(static function (stdClass $item) {
                    return new ShipmentPiece([
                        'label_id' => $item->labelId,
                        'tracker_code' => $item->trackerCode,
                        'parcel_type' => $item->parcelType,
                        'quantity' => $item->pieceNumber,
                        'weight' => $item->weight,
                    ]);
                })
                ->all(),
        ]);
    }

    /**
     * Get the http body for the API request.
     *
     * @param  \Mvdnbrk\DhlParcel\Resources\Parcel $parcel
     * @return string
     * @throws \Exception
     */
    protected function getHttpBody(Parcel $parcel)
    {
        /* @noinspection PhpComposerExtensionStubsInspection */
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
