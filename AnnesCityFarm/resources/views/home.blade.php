@extends('layouts.app')

@section('content')
    <div class="container mx-5">
    
        <!--testing-->

        <div>
            <h1>Hello World</h1>
            <h3>This is a laravel-bootstrap template</h3>
            <div class="mt-5">
                <button type="button" class="btn btn-primary">Primary</button>
                <button type="button" class="btn btn-secondary">Secondary</button>
                <button type="button" class="btn btn-success">Success</button>
                <button type="button" class="btn btn-danger">Danger</button>
                <button type="button" class="btn btn-warning">Warning</button>
                <button type="button" class="btn btn-info">Info</button>
                <button type="button" class="btn btn-light">Light</button>
                <button type="button" class="btn btn-dark">Dark</button>

                <button type="button" class="btn btn-link">Link</button>
            </div>
            <!--testing ends-->
        </div>



        <div class="container bg-red-200 col-12">
            <button type="button" class="btn btn-primary" disabled>Primary button</button>

        </div>
    </div>
@endsection
