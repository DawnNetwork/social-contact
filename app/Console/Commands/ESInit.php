<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init laravel es for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //创建template
            $client = new Client();
            $url=config('scout.elasticsearch.hosts')[0].'/_template/tmp';//创建(template url)模板路径
            $param=[
               'json'=>[
                    'template'=>config('scout.elasticsearch.index'),//对定义好的索引起作用
                    'mappings'=>[
                        '_default'=>[//默认的设置
                            'dynamic_templates'=>[//动态的模板
                                [
                                    'strings'=>[
                                        'match_mapping_type'=>'string',
                                        'mapping'=>[
                                            'type'=>'text',
                                            'analyzer'=>'ik_smart',
                                            'fields'=>[
                                                'keyword'=>[
                                                    'type'=>'keyword'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]   
                        ]
                    ],
               ],
            ];
            $client = new Client([
                // Base URI is used with relative requests
                'url' => $url,
                // You can set any number of default request options.
                'param'  => $param,
            ]);
            $this->info("============创建模板成功============");
        //创建index
            $url=config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');//创建(template url)模板路径
            $param=[
               'json'=>[
                    'settings'=>[
                        'refresh_interval'=>'5s',
                        'number_of_shards'=>1,
                        'number_of_replicas'=>0,
                    ],
                    'mappings'=>[
                        '_default_'=>[
                           '_all'=>[
                              'enabled'=>false
                           ]
                        ]
                    ]
               ]
            ];
            $client = new Client([
                // Base URI is used with relative requests
                'url' => $url,
                // You can set any number of default request options.
                'param'  => $param,
            ]);
            $this->info("============创建索引成功============");
    }
}
