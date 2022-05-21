<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as baseSerializer;

/**
 * Service for data serialize
 *
 * Class Serializer
 *
 * @package App\Service
 */
class Serializer
{
    /**
     * Serializer component.
     *
     * @var baseSerializer
     */
    protected baseSerializer $serializer;

    /**
     * Serializer constructor.
     */
    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new baseSerializer($normalizers, $encoders);
    }

    /**
     * Normalize data to current format.
     *
     * @param mixed $data inner data
     * @param string|null $format serialize format
     * @param array $fields array for returning fields
     * @param array|null $callback array for functions
     *
     * @return float|int|bool|\ArrayObject|array|string|null
     * @throws ExceptionInterface
     */
    public function normalize(mixed $data,
                              string|null $format,
                              array $fields,
                              array|null $callback = null): float|null|int|bool|\ArrayObject|array|string
    {
        return $this->serializer->normalize($data, $format, [
            AbstractNormalizer::ATTRIBUTES => $fields,
            AbstractNormalizer::CALLBACKS => $callback
        ]);
    }

    /**
     * Call base serializer method.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->serializer->$name($arguments);
    }
}
