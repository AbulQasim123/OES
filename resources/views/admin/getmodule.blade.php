@extends('layout/admin-layout')
@section('admin-space')
<style>
    .customcard, img{
        height: 6rem;
    }
    .card{
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        max-height: auto;
    }
</style>
<h2 align="center">There are here your Module</h2>
<hr style="border: 1px solid black;">
<div class="container">
    <div class="row customcard">
        @foreach($modules as $module)
        <div class="col-md-3 col-lg-4 col-sm-6">
            <div>
                <h4>{{ $module->test_name }}</h4>
            </div>
            <div class="card">
                <img  src="{{ asset('images/'.$module->image) }}" class="card-img-top" alt="Error">
                <div class="card-body">
                    <h5 class="card-title">{{ $module->subject }}</h5>
                    <p class="card-text">{{ $module->title }}</p>
                    <a href="#" class="btn btn-primary mt-auto">{{ $module->amount }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection