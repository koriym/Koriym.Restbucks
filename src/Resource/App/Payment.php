<?php

namespace Koriym\Restbucks\Resource\App;

use BEAR\Resource\ResourceObject;
use Doctrine\Common\Cache\Cache;
use Ray\Di\Di\Named;

class Payment extends ResourceObject
{
    /**
     * @var Cache
     */
    private $storage;

    /**
     * @Named("restbucks")
     */
    public function __construct(Cache $storage)
    {
        $this->storage = $storage;
    }

    public function onGet($id)
    {
        if (! $this->storage->contains($id)) {
            $this->code = 401; // Unauthorized

            return $this;
        }
        $this->code = 200;

        return $this;
    }

    public function onPut($id, $card_no, $expires, $name, $amount)
    {
        if (! $this->storage->contains($id)) {
            $this->code = 401; // Unauthorized

            return $this;
        }
        $order = $this->storage->fetch($id);
        $order['card_no'] = $card_no;
        $order['expires'] = $expires;
        $order['name'] = $name;
        $order['amount'] = $amount;
        // 201 created
        $this->body = $order;

        return $this;
    }
}
