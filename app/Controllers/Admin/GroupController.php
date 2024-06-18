<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class GroupController extends BaseController
{
    /** @var \App\Models\GroupModel */
    private $groupModel;

    public function __construct()
    {
        $this->groupModel = model('App\Models\GroupModel');
    }

    public function index()
    {
        $groups = $this->groupModel->findAll();

        return view('admin/group/index', [
            'groups' => $groups
        ]);
    }

    public function save(int $id)
    {
        $formData = $this->request->getPost();
        if ($this->groupModel->update($id, $formData)) {
            return redirect()->back();
        }
    }
}
