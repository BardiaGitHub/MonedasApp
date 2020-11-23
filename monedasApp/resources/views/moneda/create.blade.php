@extends('moneda.layout')
@section('container')


<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Insertar nueva moneda</h2>
        </div>
        <div class="pull-right">
                <a class="btn btn-info" href="{{ route('moneda.index') }}"><i class="icon-reply"></i></a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error!</strong> Por favor comprueba los campos<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="margin-top: 20px;">
    <form action="{{ route('moneda.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label for="nombre">Nombre de la moneda</label>
        <input type="text" class="form-control"  placeholder="nombre" name ="nombre" value="{{ old('nombre') }}" required>
      </div>
      <div class="form-group">
        <label for="simbolo">Símbolo de la moneda</label>
        <input type="text" class="form-control"  placeholder="simbolo" name ="simbolo" value="{{ old('simbolo') }}" required>
      </div>
      <div class="form-group">
        <label for="pais">País de la moneda</label>
        <input type="text" class="form-control"  placeholder="pais" name ="pais" value="{{ old('pais') }}" required>
      </div>
      <div class="form-group">
        <label for="cambioEuro">Cambio a Euros (1€ = x cantidad de la moneda a insertar)</label>
        <input type="number" step="any" min="0" class="form-control"  placeholder="cambio a Euros" name ="cambioEuro" value="{{ old('cambioEuro') }}" required>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha de creación de la moneda</label>
        <input type="date" class="form-control" name ="fecha" value="{{ old('fecha') }}">
      </div>
      <div class="form-group">
        <h4>Fotografías de las monedas y/o billetes</h4>  
        <input type="file" class="form-control" name="imagenes[]" multiple />
      </div>
      
      <button type="submit" class="btn btn-primary">Insertar</button>
    </form>
</div>

@endsection