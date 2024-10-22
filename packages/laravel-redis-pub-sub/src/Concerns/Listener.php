<?php


namespace MyanmarCyberYouths\RedisPubSub\Concerns;

use Exception;
use MyanmarCyberYouths\RedisPubSub\Contracts\Event;
use Prwnr\Streamer\EventDispatcher\ReceivedMessage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait  Listener
{
    /**
     * @throws Exception
     */
    public function handle(ReceivedMessage $message): void
    {
        // get the classname from event
        $className = $message->getData()['className'];

        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());

        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer($classMetadataFactory)];
        $serializer = new Serializer($normalizers, $encoders);

        // create the event instance from the message data
        $event = $serializer->denormalize($message->getData(), $className, 'json', [
            AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
        ]);

        if (!$event instanceof Event) {
            throw new Exception('The event must be an instance of ' . Event::class . PHP_EOL);
        }

        if (!method_exists($this, 'listen')) {
            throw new Exception('The listener must implement a listen method' . PHP_EOL);
        }

        $this->listen($event);
    }


}
