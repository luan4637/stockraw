<?php
namespace App\Models;

class FinancialModel implements \JsonSerializable
{
    /** @var string */
    public $date;
    /** @var string */
    public $value;

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