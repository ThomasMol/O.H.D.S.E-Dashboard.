@extends('layout')
@section('title','Transactie')
@section('content')
<header>
    <h2>Transacties uploaden</h2>
</header>


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="/transacties/upload" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                        <label for="csv_file" class="col-md-4 control-label">CSV bestand om te importeren</label>

                        <div class="col-md-6">
                            <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                            @if ($errors->has('csv_file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('csv_file') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Parse CSV
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
