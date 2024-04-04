<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::any('/{path?}', function(Request $req, $path = null) {



  $data = "Hello, world!";

  // File path
  $filename = "example.txt";




  $client = new HttpClient([
    // 'base_uri' => 'http://app:8181',
        'base_uri' => 'https://staging.travware.info:443',
    'http_errors' => false, // disable guzzle exception on 4xx or 5xx response code

  ]);
  if(!$path)
  $path = '/';

  $isfile = false;

  $fileExtension = pathinfo($path, PATHINFO_EXTENSION);


// Check if the file extension indicates an image
if (in_array($fileExtension, ['ico','jpg', 'jpeg', 'png', 'gif','js','css'])) {


    $isfile = true;

}


//   $res  =  Storage::get($filename);
//   $newheader = json_decode($res,true);

  if($isfile)
  $newheader = [];
  $newheader = [];
//   dd($newheader);
  $resp = $client->request($req->method(), $path, [
        // 'headers' => $newheader,
        'query' => $req->query(),
        'body' => $req->getContent(),
        'form_params' => $req->post(),
    ]);

//     dd
//     ($resp,
//     $resp->getBody()->getContents(),
//     $resp->getHeaders()

// );
$getContenets  = str_replace("https://staging.travware.info:443", "http://localhost", $resp->getBody()->getContents());
$newheader = $resp->getHeaders();

// dd($newheader);
// unset($newheader['Server']);
// unset($newheader['P3P']);
// unset($newheader['Expires']);
// unset($newheader['Cache-Control']);
// unset($newheader['Pragma']);
// unset($newheader['Vary']);
// unset($newheader['Set-Cookie']);
// unset($newheader['X-Frame-Options']);
unset($newheader['Transfer-Encoding']);
// unset($newheader['Content-Type']);



// unset($newheader['Server']);
// unset($newheader['Server']);
// unset($newheader['Server']);
// unset($newheader['Server']);
// unset($newheader['Server']);
// unset($newheader['Server']);

// if(!$isfile)
// Storage::put($filename, json_encode($newheader));

// $res  =  Storage::get($filename);
// $newheader = json_decode($res);
// dd($newheader);

// return view('welcome');
  $dd = response($getContenets, $resp->getStatusCode())
//   ->withHeaders(($resp->getHeaders()))
    //  ->withHeaders(($req->header()))
    ->withHeaders($newheader)
  ;

;  return $dd;
  return $client->request($req->method(), $path);
})
->where('path', '.*')
->withoutMiddleware(['csrf']);

// Route::get('/', function () {

//     $users = User::all();
//     dd($users,2);
//     return view('welcome');
// });
