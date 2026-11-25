<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Contracts\ShouldAuthenticate;
use Mvdnbrk\DhlParcel\Resources\Shipment;

class Labels extends BaseEndpoint implements ShouldAuthenticate
{
    public const PDF = 'application/pdf';

    public const ZPL = 'application/zpl';

    /**
     * Get a shipment label by label id, as a PDF unless another content type is given.
     *
     * @return string
     */
    public function get(Shipment|string $value, string $accept = self::PDF)
    {
        if ($value instanceof Shipment) {
            $value = $value->label_id;
        }

        $response = $this->performApiCall(
            'GET',
            'labels/'.$value,
            null,
            ['Accept' => $accept]
        );

        return $response;
    }

    /**
     * Get a shipment label as a PDF.
     *
     * @return string
     */
    public function pdf(Shipment|string $value)
    {
        return $this->get($value, self::PDF);
    }

    /**
     * Get a shipment label as ZPL, for thermal printers.
     *
     * @return string
     */
    public function zpl(Shipment|string $value)
    {
        return $this->get($value, self::ZPL);
    }
}
