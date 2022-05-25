<?php
    $title = "Katalog produktów";
    $lazy = True;
    $catalog = True;
?>
@extends('layouts.app')

@section('content')
<article class="catalog">
    @include('partials.products')
</article>
@include('partials.search')
@endsection
