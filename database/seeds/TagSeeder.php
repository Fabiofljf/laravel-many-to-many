<?php

use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //

        //$tags = ['coding', 'laravel', 'css', 'js', 'vue', 'sql'];

        /*      foreach ($tags as $tag) {
            $new_tag = new Tag();
            $new_tag->name = $tag;
            $new_tag->slug = Str::slug($new_tag->name);
            $new_tag->save();
        } */

        for ($i = 0; $i < 10; $i++) {
            $new_tag = new Tag();
            $new_tag->name = $faker->word();
            $new_tag->slug = Str::slug($new_tag->name);
            $new_tag->save();
        }
    }
}
