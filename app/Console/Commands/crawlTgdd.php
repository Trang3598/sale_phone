<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;
use Goutte;
use Illuminate\Support\Facades\DB;

class crawlTgdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:tgdd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $crawler = Goutte::request('GET', 'https://www.thegioididong.com/dtdd-apple-iphone');
        $image = $crawler->filter('.item a img')->each(function ($node) {
            return ($node->attr('src'));
        });
        $name_phone = $crawler->filter('.item a h3')->each(function ($node) {
            return ($node->text());
        });
        $price = $crawler->filter('.item a .price span')->each(function ($node) {
            return ($node->text());
        });
        $promotion_price = $crawler->filter('.item a .price strong')->each(function ($node) {
            return ($node->text());
        });
        $detail = $crawler->filter('.item a .bginfo span')->each(function ($node) {
            return ($node->text());
        });

    }
}
