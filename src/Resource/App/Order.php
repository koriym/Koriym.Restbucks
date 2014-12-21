<?php

namespace Koriym\Restbucks\Resource\App;

use BEAR\Resource\ResourceObject;
use BEAR\Resource\Annotation\Link;
use Doctrine\Common\Cache\Cache;
use Ray\Di\Di\Named;

class Order extends ResourceObject
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

    /**
     * @var array
     */
    private $menu = [
        'latte' => ['cost' => 2.5],
        'tea' => ['cost' => 2.0]
    ];

    public function onGet($id)
    {
        if (! $this->storage->contains($id)) {
            $this->code = 404; // NotFound

            return $this;
        }
        $this->body = $this->storage->fetch($id);

        return $this;
    }

    /**
     * @Link(rel="payment", href="app://self/payment{?id}")
     */
    public function onPost($drink)
    {
        if (!isset($this->menu[$drink])) {
            $this->code = 404; // Not found

            return $this;
        }
        $this['drink'] = $drink;
        $this['cost'] = $this->menu[$drink]['cost'];

        // order id
        $orderId = date('is'); // min+sec
        $this['id'] = $orderId;
        // 201 created
        $this->code = 201;
        // save
        $this->storage->save($orderId, $this->body);

        return $this;
    }

    /**
     * @Link(rel="payment", href="app://self/payment{?id}")
     */
    public function onPut($id, $addition = null, $status = null)
    {
        if (! $this->storage->contains($id)) {
            $this->code = 404; // NotFound

            return $this;
        }
        $this->body = $this->storage->fetch($id);
        // update
        if ($addition) {
            $this['addition'] = $addition;
        }
        if ($status) {
            $this['status'] = $status;
        }
        $this->code = 100; // continue
        $this->storage->save($id, $this->body);

        return $this;
    }

    /**
     * Delete
     *
     * @param int $id order id
     *
     * @return Order
     */
    public function onDelete($id)
    {
        $this->storage->delete($id);
        $this->code = 200;

        return $this;
    }
}
