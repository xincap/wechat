<?php

namespace Xincap\Wechat\Console\Commands;

use Illuminate\Console\Command;

class Wechat extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:wechat {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new wechat function';
    
    protected $filePath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        $name = ucfirst($this->argument('name'));
        
        $lower = $this->underLower($name);
        
        $this->filePath = dirname(dirname(__DIR__));
        
        $root = $this->filePath . '/data/console/';

        $class = $root . 'Example.php';
        $pre = $root . 'ExamplePreListener.php';
        $post = $root . 'ExamplePostListener.php';

        $this->writeClass($name, $lower, $class);
        $this->writePreListener($name, $lower, $pre);
        $this->writePostListener($name, $lower, $post);
        $this->writeEventService($name, $lower);
        
        $this->info('Create Success.');
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    protected function underLower($str) {
        return strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str));
    }

    /**
     * 
     * @param type $src
     */
    protected function checkExist($src) {
        if (!file_exists($src)) {
            $this->error($src . ' Not Found.');
            exit;
        }
    }

    /**
     * 
     * @param string $name
     * @param type $lower
     * @param type $src
     */
    protected function writeClass($name, $lower, $src) {

        $this->checkExist($src);

        $content = file_get_contents($src);
        $content = str_replace('wechat.dream.pre', 'wechat.' . $lower . '.pre', $content);
        $content = str_replace('wechat.dream.post', 'wechat.' . $lower . '.post', $content);
        $content = str_replace('Example {', $name . ' {', $content);

        //file
        $name = $name . '.php';
        
        $file = $this->filePath . '/Plugin/' . $name;
        
        if (file_exists($file)) {
            $this->error($file . ' Already Exist.');
            exit;
        }
        file_put_contents($file, $content);
    }

    /**
     * 
     * @param string $name
     * @param type $lower
     * @param type $src
     */
    protected function writePostListener($name, $lower, $src) {

        $this->checkExist($src);

        $content = file_get_contents($src);
        $content = str_replace('ExamplePostListener', $name . 'PostListener', $content);

        $name = $name . 'PostListener.php';
        $file = $this->filePath . '/Listeners/' . $name;

        if (file_exists($file)) {
            $this->error($file . ' Already Exist.');
            exit;
        }

        file_put_contents($file, $content);
    }

    /**
     * 
     * @param string $name
     * @param type $lower
     * @param type $src
     */
    protected function writePreListener($name, $lower, $src) {

        $this->checkExist($src);
        $content = file_get_contents($src);
        $content = str_replace('ExamplePreListener', $name . 'PreListener', $content);
        $content = str_replace("'example'", "'{$lower}'", $content);

        $name = $name . 'PreListener.php';
        $file = $this->filePath . '/Listeners/' . $name;

        if (file_exists($file)) {
            $this->error($file . ' Already Exist.');
            exit;
        }

        file_put_contents($file, $content);
    }

    /**
     * 
     * @param type $name
     * @param type $lower
     */
    protected function writeEventService($name, $lower) {
        $src = dirname(app_path()) . '/data/console/Listener.php';
        $content = file_get_contents($src);
        $content = str_replace('wechat.example.pre', 'wechat.' . $lower . '.pre', $content);
        $content = str_replace('wechat.example.post', 'wechat.' . $lower . '.post', $content);
        $content = str_replace('ExamplePreListener', $name . 'PreListener', $content);
        $content = str_replace('ExamplePostListener', $name . 'PostListener', $content);

        $file = dirname(__DIR__) .'/Providers/XincapWechatServiceProvider.php';

        $text = file_get_contents($file);
        $old = "protected \$listen = [";
        $new = "protected \$listen = [";
        if (PATH_SEPARATOR == ':') {
            $new = $new . "\n" . $content;
        } else {
            $new = $new . "\r\n" . $content;
        }
        $text = str_replace($old, $new, $text);
        file_put_contents($file, $text);
    }

}
