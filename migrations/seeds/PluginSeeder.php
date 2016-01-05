<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


class PluginSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        DB::table('plugin')->insert([
            'name'  => 'chat',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'dream',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'flight',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'jie_meng',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'joke',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'mobile_region',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'kong_qi',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'game',
            'intro' => 'test'
        ]);
        
        DB::table('plugin')->insert([
            'name'  => 'train',
            'intro' => 'test'
        ]);
        
        $plugins   = DB::table('plugin')->get();
        
        foreach ($plugins as $key => $plugin) {
            
            DB::table('plugin_wechat')->insert([
                'wechat_id'   => 1,
                'plugin_id' => $plugin->id
            ]);
            
        }
        
    }

}
