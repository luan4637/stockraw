<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Services;

class CodeController extends BaseController
{
    /** @var \App\Models\GroupModel */
    private $groupModel;
    /** @var \App\Models\CodeModel */
    private $codeModel;
    /** @var \Config\StockExchanges */
    private $serviceStockExchanges;

    public function __construct()
    {
        $this->groupModel = model('App\Models\GroupModel');
        $this->codeModel = model('App\Models\CodeModel');
        $this->serviceStockExchanges = Services::stockExchanges();
    }

    public function index()
    {
        $groups = $this->groupModel->findAll();
        $codes = $this->codeModel->where('active', 1)->findAll();

        return view('admin/code/index', [
            'codes' => $codes,
            'exchanges' => $this->serviceStockExchanges->getExchanges(),
            'groups' => $groups
        ]);
    }

    public function save(int $id)
    {
        $formData = $this->request->getPost();
        if ($this->codeModel->update($id, $formData)) {
            return redirect()->back();
        }
    }

    public function delete(int $id)
    {
        if ($this->codeModel->update($id, ['active' => 0])) {
            return redirect()->back();
        }
    }
}
