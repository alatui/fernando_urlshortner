<?php

namespace App\Http\Controllers\Shortener;
use App\ShortUrl;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class URLController extends Controller{

    protected $shortUrl;

    public function __construct(ShortUrl $shortUrl){
        $this->shortUrl = $shortUrl;
    }

    public function home(){
        $top = ShortUrl::where('redirects','>',0)->orderBy('redirects','desc')->take(10)->get();
        $latest = ShortUrl::latest()->take(10)->get();
        $baseUrl =config('app.url');
        return view('shortener.home', compact('top','latest','baseUrl'));
    }

    public function show($code){
        $shortUrl = $this->shortUrl->where('code','=',$code)->firstOrFail();
        return view('shortener.shorted',[
            'url'=>$shortUrl->url,
            'shortUrl'=>$shortUrl,
            'baseUrl' => config('app.url'),
        ]);
    }

    public function shorten(Request $request){
        $this->validate($request,$this->shortUrl->rules);
        $url = $request->input('url');
        $shortUrl = $this->shortUrl->shorten($url);
        return redirect()->route('url-preview',['code'=>$shortUrl->code]);
    }

    public function redirect($code){
        $shortUrl = $this->shortUrl->where('code','=',$code)->firstOrFail();
        $shortUrl->increment('redirects');
        return redirect($shortUrl->getUrl());
    }

}