<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonAnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mon_ans')->delete();
        DB::table('mon_ans')->truncate();
        DB::table('mon_ans')->insert([
            ['id' => 1, 'food_name' => 'Cá Mú 3 món', 'image' => 'https://th.bing.com/th/id/R.268497c5eF7e693346dd99418d7b595?rik=hg4Gz0QCHatGiQ&pid=ImgRaw&r=0', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 2, 'food_name' => 'Cá mú nấu chua', 'image' => 'https://bing.com/th?id=OSK.f0d508eba493358177f6716ca1168b47', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 3, 'food_name' => 'Cá mú hấp xì dầu', 'image' => 'https://bing.com/th?id=OSK.b47cd795d6853470595440a5bf56112a', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 4, 'food_name' => 'Thịt bò nướng lá lốt', 'image' => 'https://bing.com/th?id=OSK.4c0a692ac7b6a12b6176c68a2fb11', 'price' => 1000, 'status' => 1, 'id_category' => 2],
            ['id' => 5, 'food_name' => 'Thịt bò hầm', 'image' => 'https://bing.com/th?id=OSK.f186c7afb0f1bac3e930a9644890bd1', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 6, 'food_name' => 'Thịt bò xào củ cải', 'image' => 'https://cookbeo.com/media/2020/09/thit-bo-xao-hanh-tay/mon-thit-bo-xao-hanh-tay.jpg', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 7, 'food_name' => 'Tôm hùm sốt bơ tỏi', 'image' => 'https://th.bing.com/th/id/OIP.S7brCLFyQjoqK4m6-ggAHaGP?rs=1&pid=ImgDetMain', 'price' => 1999, 'status' => 1, 'id_category' => 3],
            ['id' => 8, 'food_name' => 'Tôm hùm nướng', 'image' => 'https://th.bing.com/th/id/OIP.1HK5Zp7W0zEXKUZs1rKr-QHaE8?rs=1&pid=ImgDetMain', 'price' => 1999, 'status' => 1, 'id_category' => 3],
            ['id' => 9, 'food_name' => 'Cháo bào ngư sốt tiêu xanh', 'image' => 'https://cdn.tgdd.vn/2021/09/CookRecipe/Avatar/bo-sot-tieu-xanh-thumbnail-1.jpg', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 10, 'food_name' => 'Cua hoàng đế hấp', 'image' => 'https://th.bing.com/th/id/R.b35a290b04abe762b411cb0fd7c707?rik=abU5fMt%2fPNjvrA&pid=ImgRaw&r=0', 'price' => 2000, 'status' => 1, 'id_category' => 4],
            ['id' => 11, 'food_name' => 'Cua hoàng đế sốt bơ tỏi', 'image' => 'https://th.bing.com/th/id/OIP.crLQ9cBZpUDGvlrf-pF3OAAAAA?rs=1&pid=ImgDetMain', 'price' => 3000, 'status' => 1, 'id_category' => 4],
            ['id' => 12, 'food_name' => 'Cua hoàng đế bơ tỏi', 'image' => 'https://i.ytimg.com/vi/x4PMKE9kv9A/mqdefault.jpg', 'price' => 3000, 'status' => 1, 'id_category' => 4],
            ['id' => 13, 'food_name' => 'Ốc cà na bơi tỏi', 'image' => 'https://nauankhongkho.com/wp-content/uploads/2017/08/10.png', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 14, 'food_name' => 'Ốc hương xào me', 'image' => 'https://th.bing.com/th/id/OIP.XPS_E4YxrhK7Z9c_FICG9wHaET?rs=1&pid=ImgDetMain', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 15, 'food_name' => 'Ốc hương xào me', 'image' => 'https://haisangous.com/wp-content/uploads/2021/11/oc-huong-xao-me-1.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 16, 'food_name' => 'Ba chỉ bò mỹ nướng', 'image' => 'https://gofoodmarket.vn/wp-content/uploads/2022/09/ba-chi-bo-my-nuong-anh-thumb.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 6],
            ['id' => 17, 'food_name' => 'Ba chỉ xào dưa cải', 'image' => 'https://th.bing.com/th/id/OIP.ocWT0WvEwSgDb?rs=1&pid=ImgDetMain', 'price' => 1000, 'status' => 1, 'id_category' => 6],
            ['id' => 18, 'food_name' => 'Ba chỉ xào rim', 'image' => 'https://th.bing.com/th/id/OIP.NMjI2okN8qS6hENJNoSrA?rs=1&pid=ImgDetMain', 'price' => 2000, 'status' => 1, 'id_category' => 6],
            ['id' => 19, 'food_name' => 'Cocacola', 'image' => 'https://bizweb.dktcdn.net/thumb/large/100/289/094/products/pixlr-bg-result-11.png?v=1657094358003', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 20, 'food_name' => 'Sting', 'image' => 'https://cdn.tgdd.vn/Files/2019/11/12/1218818/4-tac-hai-cua-nuoc-tang-luc.jpg', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 21, 'food_name' => 'Bia larue', 'image' => 'https://ruouhanoiquocgia.com/wp-content/uploads/2019/11/larue-la-gi-cong-nghe-gia-thanh-nong-do-con-ruou-uy-tin.jpg', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 22, 'food_name' => 'Rượu soju', 'image' => 'https://ruounhapkhau.com.vn/wp-content/uploads/2019/11/soju.jpg', 'price' => 3000, 'status' => 1, 'id_category' => 7],
            ['id' => 23, 'food_name' => 'Táo mĩ', 'image' => 'https://img2.thuthuatphanmem.vn/uploads/2019/03/14/anh-qua-tao-dep-nhat_095349569.jpg', 'price' => 200, 'status' => 1, 'id_category' => 8],
            ['id' => 24, 'food_name' => 'Nho mỹ', 'image' => 'https://th.bing.com/th/id/OIP.fazs_gGmINBJg?s=ImgDetMain', 'price' => 300, 'status' => 1, 'id_category' => 8],
        ]);
    }
}
