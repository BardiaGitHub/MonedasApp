@extends('moneda.layout')

@section('style')
<style type="text/css">
    .containerImg {
        position: relative;
        cursor: pointer;
        height: 100px;
        width: 100px;
        float: left;
        margin-right: 5px;
    }

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: 0;
        transition: .5s ease;
        background-color: rgb(250, 0, 0);
    }
    
    .containerImg:hover .overlay {
        opacity: 0.8;
    }
    
    .text {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>
@endsection

@section('container')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Editar {{ $moneda->nombre }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('moneda.index') }}"><i class="icon-reply"></i></a>
        </div><br>
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

@if ($message = Session::get('image'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
@endif

<div style="margin-top: 20px;">
    <form action="{{ route('moneda.update', $moneda->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
      <div class="form-group">
        <label for="nombre">Nombre de la moneda</label>
        <input type="text" class="form-control"  placeholder="nombre" name ="nombre" value="{{ old('nombre', $moneda->nombre) }}" required>
      </div>
      <div class="form-group">
        <label for="simbolo">Símbolo de la moneda</label>
        <input type="text" class="form-control"  placeholder="simbolo" name ="simbolo" value="{{ old('simbolo', $moneda->simbolo) }}" required>
      </div>
      <div class="form-group">
        <label for="pais">País de la moneda</label>
        <input type="text" class="form-control"  placeholder="pais" name ="pais" value="{{ old('pais', $moneda->pais) }}" required>
      </div>
      <div class="form-group">
        <label for="cambioEuro">Cambio a Euros (1€ = x cantidad de la moneda a insertar)</label>
        <input type="number" step="any" min="0" class="form-control"  placeholder="cambio a Euros" name ="cambioEuro" value="{{ old('cambioEuro', $moneda->cambioEuro) }}" required>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha de creación de la moneda</label>
        <input type="date" class="form-control" name ="fecha" value="{{ old('fecha',$moneda->fecha) }}">
      </div>
      
      <div class="form-group">
        @if (count($monedaImagenes))
        <h4>Fotografías de las monedas y/o billetes</h4>  
        <div class="alert alert-success" style="overflow: hidden">
            @foreach ($monedaImagenes as $imagen)
                <div class="containerImg" onclick="deleteImage({{ $imagen->id }})">
                    <img class="image" src="{{ url($imagen->filepath) }}" alt="fotografía" style="object-fit: cover; width: 100px; height: 100px;"/>
                    <div class="overlay">
                        <div class="text">Borrar</div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        <h5>Añadir imágenes: </h5>
        <input type="file" class="form-control" name="imagenes[]" multiple />
      </div>
      <button type="submit" class="btn btn-primary">Editar</button>
    </form>
    <br>
</div>

<form id="deleteForm" action="{{ url('image/') }}" method="POST">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteImage(id) {
        let retVal = confirm('¿Seguro que quieres borrar esta imagen?');
        if(retVal) {
            var formDelete = document.getElementById('deleteForm');
            formDelete.action += '/' + id;
            formDelete.submit();
        }
    }
</script>

@endsection