<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class WechatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer   = DB::table('customer')->where(['email'=>'mr.sk@qq.com'])->first();
        
        $time   = date('Y-m-d H:i:s');
        
        DB::table('wechat')->insert([
            'customer_id'=>$customer->id,
            'app_id' => 'wxc5398ace5f1edd4d',
            'app_secret' => '7d714fbe0304d3c998a3bd8fbb40437f',
            'token'     => '83c3893cc9e0b27efd6641198ed63a29',
            'des_key'       => 'IspKgYJNoaJLTQOKemWpJGGDRQQgohXdnycZxgBYfXu',
            'created_at'    => $time,
            'updated_at'    => $time
        ]);
    }
}
