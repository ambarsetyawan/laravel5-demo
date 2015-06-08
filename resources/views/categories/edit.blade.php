@extends('app')

@section('content')
<div class="container">

    @include('common.errors')

    {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch']) !!}

        @include('categories.fields')

    {!! Form::close() !!}
</div>
@endsection
