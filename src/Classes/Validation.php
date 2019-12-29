<?php

namespace AshAllenDesign\ShortURL\Classes;

use AshAllenDesign\ShortURL\Exceptions\ValidationException;

class Validation
{
    /**
     * Validate all of the config related to the
     * library.
     *
     * @return bool
     * @throws ValidationException
     */
    public function validateConfig(): bool
    {
        return $this->validateURLLength() && $this->validateTrackingOptions();
    }

    /**
     * Validate that the URL Length parameter specified
     * in the config is an integer that is above 0.
     *
     * @return bool
     * @throws ValidationException
     */
    protected function validateURLLength(): bool
    {
        $urlLength = config('short-url.url_length');

        if (!is_int($urlLength)) {
            throw new ValidationException('The config URL length is not a valid integer.');
        }

        if ($urlLength <= 0) {
            throw new ValidationException('The config URL length must be above 0.');
        }

        return true;
    }

    /**
     * Validate that each of the tracking options are
     * booleans.
     *
     * @return bool
     * @throws ValidationException
     */
    protected function validateTrackingOptions(): bool
    {
        $trackingOptions = config('short-url.tracking');

        if (!is_bool($trackingOptions['default_enabled'])) {
            throw new ValidationException('The default_enabled config variable must be a boolean.');
        }

        foreach ($trackingOptions['fields'] as $trackingOption => $value) {
            if (!is_bool($value)) {
                throw new ValidationException('The '.$trackingOption.' config variable must be a boolean.');
            }
        }

        return true;
    }
}