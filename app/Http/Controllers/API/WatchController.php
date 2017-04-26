<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Film;
use App\Episode;

class WatchController extends Controller
{
  public function getLink($url)
  {
    $namespace = 'App\Http\Controllers\API\Watch';

    $getLinkController = $namespace.'\GetLinkController';

    $url = base64_decode($url);

    if (filter_var($url, FILTER_VALIDATE_URL))
    {
      $class = $namespace.'\GetLink\\'.studly_case_domain(parse_url($url)['host']);

      if (class_exists($class))
      {
        $getLinkController = $class;
      }
    }

    $getLinkController = new $getLinkController;
    $getLinkController->setUrl($url);

    return $getLinkController->getResults();
  }
  
  public function watchFilm($film_id)
  {
    $film = Film::find($film_id);
    
    return $film->episodes;
  }
}
