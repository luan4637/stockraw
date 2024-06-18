<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Groups extends Seeder
{
    public function run()
    {
        $rows = [
            [ 'id' => '1', 'name' => 'Bán buôn'],
            [ 'id' => '2', 'name' => 'Bảo hiểm'],
            [ 'id' => '3', 'name' => 'Bất động sản'],
            [ 'id' => '4', 'name' => 'Chứng khoán'],
            [ 'id' => '5', 'name' => 'Công nghệ và thông tin'],
            [ 'id' => '6', 'name' => 'Bán lẻ'],
            [ 'id' => '7', 'name' => 'Chăm sóc sức khỏe'],
            [ 'id' => '8', 'name' => 'Khai khoáng'],
            [ 'id' => '9', 'name' => 'Ngân hàng'],
            [ 'id' => '10', 'name' => 'Nông - Lâm - Ngư'],
            [ 'id' => '11', 'name' => 'SX Thiết bị, máy móc'],
            [ 'id' => '12', 'name' => 'SX Hàng gia dụng'],
            [ 'id' => '13', 'name' => 'Sản phẩm cao su'],
            [ 'id' => '14', 'name' => 'SX Nhựa - Hóa chất'],
            [ 'id' => '15', 'name' => 'Thực phẩm - Đồ uống'],
            [ 'id' => '16', 'name' => 'Chế biến Thủy sản'],
            [ 'id' => '17', 'name' => 'Vật liệu xây dựng'],
            [ 'id' => '18', 'name' => 'Tiện ích'],
            [ 'id' => '19', 'name' => 'Vận tải - kho bãi'],
            [ 'id' => '20', 'name' => 'Xây dựng'],
            [ 'id' => '21', 'name' => 'Dịch vụ lưu trú, ăn uống, giải trí'],
            [ 'id' => '22', 'name' => 'SX Phụ trợ'],
            [ 'id' => '23', 'name' => 'Thiết bị điện'],
            [ 'id' => '24', 'name' => 'Dịch vụ tư vấn, hỗ trợ'],
            [ 'id' => '25', 'name' => 'Tài chính khác'],
        ];

        foreach ($rows as $row) {
            $this->db->table('groups')->insert($row);
        }
    }
}
