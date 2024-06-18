<?php

namespace App\Repository;

class CodeRepository
{
    /** @var App\Models\CodeModel */
    private $codeModel;

    public function __construct()
    {
        $this->codeModel = model('App\Models\CodeModel');
    }

    /**
     * @param string $name
     * @return array
     */
    public function getByName(string $name): array
    {
        return $this->codeModel->where('name', $name)->first();
    }

    /**
     * @param array $code
     * @return bool
     */
    public function save(array $code): bool
    {
        return $this->codeModel->insert($code, false);
    }
}