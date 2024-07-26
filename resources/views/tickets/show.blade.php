@extends('layouts.seller-dashboard')
@section('dashboard-content')
<div class="ec-shop-rightside col-lg-9 col-md-12">
<x-tickets :ticket="$ticket"/>
</div>
@endsection