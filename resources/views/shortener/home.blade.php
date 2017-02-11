@extends('base')
@section('title','Home')
@section('body')
    <br/>
    <div class="container">
        <div class="jumbotron">
            <h1>@lang('system.name')</h1>
            <form action="{{ route('url-create') }}" method="POST">
                @if( isset($errors) && count($errors) > 0 )
                <div class="alert alert-danger">
                    @lang('app.checkErros')
                </div>
                @endif
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                    <label class="control-label" for="url">@lang('app.url'):</label>
                    <input class="form-control" id="url" name="url" type="text" value="{{old('url')}}"></input>
                    @if($errors->has('url'))
                    <span class="error text-danger">{{ $errors->first('url') }}</span>
                    @endif
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">@lang('app.shorten')</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-6"><h3>Últimas URLs encurtadas</h3>
                <ul>
                    @foreach ($latest as $url)
                        <li><a href="{{ $baseUrl }}/{{ $url->code }}">{{ $url->getUrl() }}</a> <span class="badge"><small>{{$url->created_at->diffForHumans()}}</small></span></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6"><h3>Top URLs</h3>
                    <ol>
                        @foreach ($top as $url)
                        <li><a href="{{ $baseUrl }}/{{ $url->code }}">{{ $url->getUrl() }}</a>  <span class="badge"><small>{{$url->redirects}} {{str_plural('redirecionamento',$url->redirects)}}</small></span></li>
                        @endforeach
                    </ol>
            </div>
        </div>
    </div>
@endsection