<?php

use Illuminate\Database\Seeder;
use App\Notificaciones;

class NotificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notificaciones::create([
            'titulo' => 'Lanzamiento',
            'subtitulo' => 'Wonder woman',
            'imagen' => 'http://cdn.atomix.vg/wp-content/uploads/2017/06/GalleryComics_1920x1080_20150429_WonderWoman77_CMYK-new-neck-v2_552849f55810a9.84883346.jpg',
        ]);

        Notificaciones::create([
            'titulo' => 'Lanzamiento',
            'subtitulo' => 'Toy story 4',
            'imagen' => 'http://xewt12.com/wp-content/uploads/2015/10/TOY-STORY-4.jpg',
        ]);
    }
}
