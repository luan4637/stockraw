<?php
namespace App\Models;

class OrderModel implements \JsonSerializable
{
    /** @var string */
    public $time;
    /** @var float */
    public $price;
    /** @var float */
    public $volOrder;
    /** @var float */
    public $volCount;
    /** @var float */
    public $proportion;
    /** @var bool */
    public $increase;

    /**
     * @param array $data
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}