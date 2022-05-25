<?php
    $title = "Nie znaleziono strony";
?>
@extends('layouts.app')
@section('content')
    <article class="not-found">
        <i class="fas fa-skull-crossbones"></i>
        <h2>Wkroczyłeś na <span class="red">niebezpieczny teren</span></h2>
        <h3>Nie znaleźliśmy strony, której szukasz</h3>
        <a href="/" class="button dark">Wróć<span class="toHide"> w bezpieczne miejsce</span><span class="toShow"> do domu</span></a>
    </article>
@endsection
