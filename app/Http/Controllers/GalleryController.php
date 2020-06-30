<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\Category;

class GalleryController extends Controller
{
    public function index()
    {
        //with() MI PRECARICA LA RELAZIONE COSI' NON DOVRO' FARE UNA QUERY PER OGNI ALBUM
        $albums = Album::latest()->with('categories')->get();
//        $albums = Album::latest()->get();

        foreach ($albums as $album) {
//            return $album->categories;
        }

        return view('gallery.albums')->with('albums', $albums);
    }



    public function showAlbumByCategory(Category $category)
    {
        return view('gallery.albums')->with('albums', $category->albums); /*UGUALE A albums()->get()*/
    }



    public function showAlbumImages(Album $album)
    {
//        return Photo::whereAlbumId($album->id)->latest()->get();
        return view(
            'gallery.images',
            [
                'images' => Photo::whereAlbumId($album->id)->latest()->get(),
                'album'  => $album
            ]);
    }


}
