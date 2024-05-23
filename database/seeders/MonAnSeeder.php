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
            ['id' => 1, 'food_name' => 'Cá Mú 3 món', 'image' => 'https://motortrip.vn/wp-content/uploads/2022/01/ca-mu-lam-mon-gi-ngon-3.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 2, 'food_name' => 'Cá mú nấu chua', 'image' => 'https://bing.com/th?id=OSK.f0d508eba493358177f6716ca1168b47', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 3, 'food_name' => 'Cá mú hấp xì dầu', 'image' => 'https://bing.com/th?id=OSK.b47cd795d6853470595440a5bf56112a', 'price' => 1000, 'status' => 1, 'id_category' => 1],
            ['id' => 4, 'food_name' => 'Thịt bò nướng lá lốt', 'image' => 'https://th.bing.com/th/id/R.807cc95f7235a824fd43548c4f7238d0?rik=Ups%2fIqRRJsYxOw&pid=ImgRaw&r=0', 'price' => 1000, 'status' => 1, 'id_category' => 2],
            ['id' => 5, 'food_name' => 'Thịt bò hầm', 'image' => 'https://th.bing.com/th/id/OIP.MxzILzAiMQR63i5xGMXfrgHaHa?rs=1&pid=ImgDetMain', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 6, 'food_name' => 'Thịt bò xào củ cải', 'image' => 'https://cookbeo.com/media/2020/09/thit-bo-xao-hanh-tay/mon-thit-bo-xao-hanh-tay.jpg', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 7, 'food_name' => 'Tôm hùm sốt bơ tỏi', 'image' => 'https://th.bing.com/th/id/R.5e3570d5a490da1363c242da6a750046?rik=PwwIATUEnfE14w&pid=ImgRaw&r=0', 'price' => 1999, 'status' => 1, 'id_category' => 3],
            ['id' => 8, 'food_name' => 'Tôm hùm nướng', 'image' => 'https://cdn.noichienkhongdau.com/wp-content/uploads/2020/07/T%C3%B4m-h%C3%B9m-n%C6%B0%E1%BB%9Bng-ph%C3%B4-mai-b%E1%BA%B1ng-n%E1%BB%93i-chi%C3%AAn-kh%C3%B4ng-d%E1%BA%A7u.jpg', 'price' => 1999, 'status' => 1, 'id_category' => 3],
            ['id' => 9, 'food_name' => 'Cháo bào ngư sốt tiêu xanh', 'image' => 'https://cdn.tgdd.vn/2021/09/CookRecipe/Avatar/bo-sot-tieu-xanh-thumbnail-1.jpg', 'price' => 2000, 'status' => 1, 'id_category' => 2],
            ['id' => 10, 'food_name' => 'Cua hoàng đế hấp', 'image' => 'https://th.bing.com/th/id/R.e2de0a2bbfa98a66fde973506b1881b5?rik=RYlgQ%2fmOzdIRlQ&pid=ImgRaw&r=0', 'price' => 2000, 'status' => 1, 'id_category' => 4],
            ['id' => 11, 'food_name' => 'Cua hoàng đế sốt bơ tỏi', 'image' => 'https://cdn.dealtoday.vn/img/s654x435/fd39f9bd519e4b77b181a17043df755f.jpg?sign=-pVhvobyzsSjJjLTKqGHJQ', 'price' => 3000, 'status' => 1, 'id_category' => 4],
            ['id' => 12, 'food_name' => 'Cua hoàng đế bơ tỏi', 'image' => 'https://i.ytimg.com/vi/x4PMKE9kv9A/mqdefault.jpg', 'price' => 3000, 'status' => 1, 'id_category' => 4],
            ['id' => 13, 'food_name' => 'Ốc cà na bơi tỏi', 'image' => 'https://nauankhongkho.com/wp-content/uploads/2017/08/10.png', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 14, 'food_name' => 'Ốc hương xào me', 'image' => 'https://nauco29.com/uploads/content/oc-huong-xao-me.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 15, 'food_name' => 'Ốc hương xào me', 'image' => 'https://nauco29.com/uploads/content/oc-huong-xao-me.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 5],
            ['id' => 16, 'food_name' => 'Ba chỉ bò mỹ nướng', 'image' => 'https://gofoodmarket.vn/wp-content/uploads/2022/09/ba-chi-bo-nuong-anh-thumb.jpg', 'price' => 1000, 'status' => 1, 'id_category' => 6],
            ['id' => 17, 'food_name' => 'Ba chỉ xào dưa cải', 'image' => 'https://th.bing.com/th/id/OIP.R7i_TUhnWYA1i2Axf8Z-bgAAAA?rs=1&pid=ImgDetMain', 'price' => 1000, 'status' => 1, 'id_category' => 6],
            ['id' => 18, 'food_name' => 'Ba chỉ xào rim', 'image' => 'https://bepxua.vn/wp-content/uploads/2022/12/cach-rim-thit-ba-chi-chua-ngot-7.jpg', 'price' => 2000, 'status' => 1, 'id_category' => 6],
            ['id' => 19, 'food_name' => 'Cocacola', 'image' => 'https://th.bing.com/th/id/R.daf55bdb8f55e96e3a2084632e7cfd6e?rik=ES3u87ZZlb%2f%2fIg&pid=ImgRaw&r=0', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 20, 'food_name' => 'Sting', 'image' => 'https://th.bing.com/th/id/OIP.mKO63ShI4iEAN-IRa152VgHaHa?rs=1&pid=ImgDetMain', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 21, 'food_name' => 'Bia larue', 'image' => 'https://th.bing.com/th/id/OIP.gPTS3Z64cEFtN2BhPmW5dgHaFj?rs=1&pid=ImgDetMain', 'price' => 500, 'status' => 1, 'id_category' => 7],
            ['id' => 22, 'food_name' => 'Rượu soju', 'image' => 'https://th.bing.com/th/id/OIP.S3qIVPrzJnsxt_shgrPOaQAAAA?rs=1&pid=ImgDetMain', 'price' => 3000, 'status' => 1, 'id_category' => 7],
            ['id' => 23, 'food_name' => 'Táo mĩ', 'image' => 'https://img2.thuthuatphanmem.vn/uploads/2019/03/14/anh-qua-tao-dep-nhat_095349569.jpg', 'price' => 200, 'status' => 1, 'id_category' => 8],
            ['id' => 24, 'food_name' => 'Nho mỹ', 'image' => 'https://media.loveitopcdn.com/1254/nho-den-khong-hat-my-nhobonmuacom-2.jpg', 'price' => 300, 'status' => 1, 'id_category' => 8],
        ]);
    }
}
