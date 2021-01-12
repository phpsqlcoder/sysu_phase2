<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Article::insert([
            [
                'name' => 'Lorem ipsum 1',
                'slug' => $this->convert_to_slug('Lorem ipsum 1'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/misc/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Lorem ipsum 2',
                'slug' => $this->convert_to_slug('Lorem ipsum 2'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/misc/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Lorem ipsum 3',
                'slug' => $this->convert_to_slug('Lorem ipsum 3'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/misc/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Lorem ipsum 4',
                'slug' => $this->convert_to_slug('Lorem ipsum 4'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'Published',
                'is_featured' => '0',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/misc/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Lorem ipsum 5',
                'slug' => $this->convert_to_slug('Lorem ipsum 5'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status' => 'Published',
                'is_featured' => '0',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/misc/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);

//        $news = [];
//        for($i=6;$i<150;$i++) {
//            $new = [
//                'name' => 'Lorem ipsum '.$i,
//                'slug' => $this->convert_to_slug('Lorem ipsum '.$i),
//                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
//                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
//                'status' => 'Published',
//                'is_featured' => '0',
//                'user_id' => '1',
//                'image_url' => \URL::to('/').'/images/banner5.jpg',
//                'meta_title' => 'title',
//                'meta_keyword' => 'keyword',
//                'meta_description' => 'description',
//                'created_at' => '2019-10-06 20:31:26',
//                'updated_at' => '2019-10-06 20:31:26'
//            ];
//
//            array_push($news, $new);
//        }
//
//        \App\Article::insert($news);
    }

    public function convert_to_slug($url){

        $url = Str::slug($url, '-');

        if (\App\Page::where('slug', '=', $url)->exists()) {
            $url = $url."_2";
        }
        elseif (\App\Article::where('slug', '=', $url)->exists()) {
            $url = $url."_2";
        }

        return $url;
    }
}
