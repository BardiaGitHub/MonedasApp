@extends('moneda.layout')
@section('container')

@section('style')
<style type="text/css">

.searchInput {
    padding: 10px;
    font-size: 17px;
    border: 1px solid grey;
    float: left;
    width: 80%;
    background: #f1f1f1;
}

#searchButton {
  float: left;
  margin-left: 1%;
  width: 19%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

#searchButton:hover {
  background: #0b7dda;
}

#searchDiv::after {
  content: "";
  clear: both;
  display: table;
}

</style>
@endsection


<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h1>Monedas del mundo</h1><br>
        </div>
        @if(isset($searching))
        <div class="pull-right">
            <a class="btn btn-info" href="{{ route('moneda.index') }}"><i class="icon-reply"></i></a>
        </div><br>
        @endif
        <br>
    </div>
</div>
    
<div id="searchDiv">
    <input type="text" id="search" class="searchInput" placeholder="Buscar por nombre o país" name="search">
    <button id="searchButton" onclick="search()" class="btn btn-dark"><i class="fa fa-search"></i></button>
</div>
<br>

<form id="searchForm" action="{{ url('moneda/search/') }}" method="POST">
    @csrf
</form>

@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
@endif

<div style="margin: 2% 0; width: 100$;">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Símbolo</th>
              <th scope="col">País</th>
              <th scope="col">1€ son...</th>
              <th scope="col">Fecha</th>
              <th scope="col">num. imágenes de la moneda</th>
              <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monedas as $moneda)
              <tr>
                <th scope="row">{{ $moneda->id }}</th>
                <td scope="row">{{ $moneda->nombre }}</td>
                <td scope="row">{{ $moneda->simbolo }}</td>
                <td scope="row">{{ $moneda->pais }}</td>
                <td scope="row">...{{ $moneda->cambioEuro.$moneda->simbolo }}</td>
                <td scope="row">{{ $moneda->fecha }}</td>
                <td scope="row">
                    <?php
                        $num = 0;
                        foreach($monedaImagenes as $imagen) {
                            if($imagen->moneda_id == $moneda->id) {
                                $num++;
                            }
                        }
                        echo $num.' imágenes';
                    ?>
                </td>
                <td scope="row">
                <a class="btn btn-info btn-block" href="{{ route('moneda.show',$moneda->id) }}">Ver</a>
                <a class="btn btn-primary btn-block" href="{{ route('moneda.edit',$moneda->id) }}">Editar</a>
                <button onclick="use({{ $moneda->cambioEuro }}, '{{ $moneda->simbolo }}')" class="btn btn-success btn-block">Usar</button>
                <br/>
                <button onclick="deleteConfirmation({{ $moneda->id }})" class="btn btn-danger btn-block">Eliminar</button>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a class="btn btn-outline-success btn-block" href="{{ route('moneda.create') }}">Insertar una moneda</a>

<div id="usarMoneda" style="margin-top: 20px; margin-bottom:50px; padding: 20px;" class="alert alert-success">
    <label for="euro">Euros:</label>
    <input name="euro" type="number" step="any" min="0" class="form-control"  placeholder="Euros" id="euros" readonly><br>
    <label for="cambio" id="cambioLabel">Cambio:</label>
    <input name="cambio" type="text" class="form-control"  placeholder="Cambio" id="cambio" readonly>
</div>

<form id="deleteForm" action="{{ url('moneda/') }}" method="POST">
    @csrf
    @method('DELETE')
</form>

<script>
    var monedaInput = document.getElementById('euros');
    
    var cambio = 0;
    var signo = "";

    function use(cambio, signo) {
        monedaInput.value = '';
        monedaInput.readOnly = false;
        document.getElementById('cambio').value = '';
        this.cambio = cambio;
        this.signo = signo;
        alert('Ya puede hacer el cambio de € a ' + signo + ' en el cuadro inferior.');
    }
    
    monedaInput.addEventListener("input", function (e) {
        var resultado = monedaInput.value * cambio;
        resultado = Number.parseFloat(resultado).toFixed(2);
        document.getElementById('cambio').value = resultado + ' ' +signo;
    });
    
    function deleteConfirmation(id) {
        let retVal = confirm('¿Seguro que quieres borrar esta moneda?');
        if(retVal) {
            var formDelete = document.getElementById('deleteForm');
            formDelete.action += '/' + id;
            formDelete.submit();
        }
    }
    
    function search($value) {
        var searchInput = document.getElementById('search').value;
        if(searchInput != '') {
            var searchForm = document.getElementById('searchForm');
            searchForm.action += '/' + searchInput;
            searchForm.submit();
        } else {
            alert('El campo de búsqueda está vacío');
        }
    }
</script>
@endsection