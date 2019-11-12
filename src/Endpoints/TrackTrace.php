<?php

namespace Mvdnbrk\DhlParcel\Endpoints;

use Mvdnbrk\DhlParcel\Resources\TrackTrace as TrackTraceResource;

class TrackTrace extends BaseEndpoint
{
    /**
     * Get Track & Trace information.
     *
     * @param  string  $value
     * @return \Mvdnbrk\DhlParcel\Resources\TrackTrace
     */
    public function get(string $value)
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
