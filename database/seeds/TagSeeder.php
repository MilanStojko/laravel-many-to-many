<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorie = ['cibo', 'animali', 'geografia', 'storia', 'musica'];
        foreach ($categorie as $tag) {
            $nuovo_tag = new Tag();
            $nuovo_tag->name = $tag;
            $nuovo_tag->slug = Str::of($tag)->slug("-");
            $nuovo_tag->save();
        }
    }
}
