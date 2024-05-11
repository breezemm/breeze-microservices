<?php


namespace MyanmarCyberYouths\RedisPubSub\Concerns;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


trait SerializesEvents
{
    /**
     * @throws ExceptionInterface
     */
    public function payload(): array
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());

        $encoders = [new XmlEncoder(), new JsonEncoder()];

        $normalizers = [new ObjectNormalizer($classMetadataFactory)];

        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->normalize($this, 'json');
    }

}
