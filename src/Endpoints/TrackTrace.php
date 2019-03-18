<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\TrackTrace as TrackTraceResource;

class TrackTrace extends BaseEndpoint
{
    public function get($value)
    {
        $response = $this->performApiCall(
            'GET',
            'track-trace'.$this->buildQueryString(['key' => $value])
        );

        return new TrackTraceResource(
            collect(collect($response)->first())->all()
        );
    }
}
