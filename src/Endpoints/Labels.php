<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\Piece;
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
     * Get a shipment label by shipment object.
     *
     * @param Shipment $shipment
     * @return string
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function get(Shipment $shipment): ?string
    {
        if (empty($shipment->pieces)) {
            return null;
        }

        return $this->getLabelFromApi($shipment->pieces->pieces[0]->label_id);
    }

    /**
     * @param Piece $piece
     * @return string
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function getByPiece(Piece $piece): string
    {
        return $this->getLabelFromApi($piece->label_id);
    }

    /**
     * @param string $labelId
     * @return string
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    public function getByLabelId(string $labelId): string
    {
        return $this->getLabelFromApi($labelId);
    }

    /**
     * @param string $labelId
     * @return string
     * @throws \Mvdnbrk\DhlParcel\Exceptions\DhlParcelException
     */
    private function getLabelFromApi(string $labelId): string
    {
        return $this->performApiCall(
            'GET',
            'labels/'.$labelId,
            null,
            ['Accept' => 'application/pdf']
        );
    }
}
