@extends('moneda.layout')
@section('container')


<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ $moneda->nombre }}</h2>
        </div>
        <div class="pull-right">
                <a class="btn btn-info" href="{{ route('moneda.index') }}"><i class="icon-reply"></i></a>
        </div>
    </div>
</div>
    <div class="form-group">
    <label for="nombre">Nombre de la moneda</label>
    <input type="text" class="form-control" name ="nombre" value="{{ $moneda->nombre }}" readonly>
    </div>
    <div class="form-group">
    <label for="simbolo">Símbolo de la moneda</label>
    <input type="text" class="form-control" name ="simbolo" value="{{ $moneda->simbolo }}" readonly>
    </div>
    <div class="form-group">
    <label for="pais">País de la moneda</label>
    <input type="text" class="form-control" name ="pais" value="{{ $moneda->pais }}" readonly>
    </div>
    <div class="form-group">
    <label for="cambioEuro">Cambio a Euros (1€ = x cantidad de la moneda a insertar)</label>
    <input type="number" step="any" min="0" class="form-control" name ="cambioEuro" value="{{ $moneda->cambioEuro }}" readonly>
    </div>
    <div class="form-group">
    <label for="fecha">Fecha de creación de la moneda</label>
    <input type="date" class="form-control" name ="fecha" value="{{ $moneda->fecha }}">
    </div>
    <div class="form-group">
    @if (count($monedaImagenes))
    <h4>Fotografías de las monedas y/o billetes</h4>  
        <div class="alert alert-success">
            @foreach ($monedaImagenes as $imagen)
                <a href="{{ url($imagen->filepath) }}"><img src="{{ url($imagen->filepath) }}" alt="fotografía" style="object-fit: cover; width: 200px; height: 200px;"/></a>
            @endforeach
        </div>
    </div>
    @endif
</div>



@endsection