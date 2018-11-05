@extends('layouts.layout')
@section("migajas")
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route("users")}}">Trabajadores</a>
        </li>
        <li class="breadcrumb-item active">Registro</li>
    </ol>
@endsection
@section('content')

    <link rel="stylesheet" href="{{ URL::asset('cropper/cropper.css')}}">
    <style>
        .label {
            cursor: pointer;
        }

        .progress {
            display: none;
            margin-bottom: 1rem;
        }

        .alert {
            display: none;
        }

        .img-container img {
            max-width: 100%;
        }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Registro de Trabajadores</h4><br>
            </div>
            <div class="card-block">
                <form id="myForm" action="{{url('users/add/'.@$user->id)}}" method="POST" class="form-horizontal"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}


                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Nombre Completo</label>
                        <div class="col-md-8">
                            <input id="full_name" name="full_name" required="" type="text"
                                   value="<?php echo old('full_name') != '' ? old('full_name') : (isset($user->full_name) ? $user->full_name : ''); ?>"
                                   class="form-control" placeholder="Nombre Completo" autocomplete="on">
                            @if ($errors->has('full_name'))
                                <span class="help-block">
                        <strong>{{ $errors->first('full_name') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Teléfono</label>
                        <div class="col-md-8">
                            <input id="mobile_number" name="mobile_number" required="" type="text"
                                   value="{{old('mobile_number') != '' ? old('mobile_number') : (isset($user->mobile_number) ? $user->mobile_number : '')}}"
                                   class="form-control" placeholder="Teléfono" autocomplete="on">
                            @if ($errors->has('mobile_number'))
                                <span class="help-block">
                        <strong id="errmsg">{{ $errors->first('mobile_number') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Nombre de Usuario</label>
                        <div class="col-md-8">
                            <input id="username" name="username" type="text" required=""
                                   value="{{old('username') != '' ? old('username') : (isset($user->username) ? @$user->username : '')}}"
                                   class="form-control" placeholder="Nombre de Usuario" autocomplete="on">
                            @if ($errors->has('username'))
                                <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Contraseña (solo modificar si se require cambiar)</label>
                        <div class="col-md-8">
                            <input id="password" name="password" type="password" value=""
                                   class="form-control" placeholder="Contraseña" autocomplete="off">
                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="question">Foto</label>
                        <div class="col-md-4">

                            <label class="label" data-toggle="tooltip" title="Subir Imagen">
                                @if(isset($user->profile_image))
                                    <img src="{{url($user->profile_image)}}" class="rounded" id="avatar">
                                @else
                                    <img class="rounded" id="avatar"
                                         src="{{url('/images/demo_image_uploader.png')}}" alt="avatar">
                                @endif
                                <input type="file" class="sr-only form-control" id="input" accept="image/*">
                                <input type="hidden" name="profile_image" id="imageBaseCode"
                                       {{!isset($user->profile_image) ? "required": ""}}>
                            </label>


                            <div class="alert" role="alert"></div>
                            @if ($errors->has('profile_image'))
                                <span class="help-block">
                        <strong>{{ $errors->first('profile_image') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-md-3 form-control-label" for="textarea-input">&nbsp;</label>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-dot-circle-o"></i>
                                Guardar
                            </button>&nbsp;
                            <a class="btn btn-secondary" href="{{route("users")}}">
                                <i class="fa fa-ban"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function () {
            //called when key is pressed in textbox
            $("#mobile_number").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#errmsg").html("Sólo dígitos").show().fadeOut("slow");
                    return false;
                }
            });
        });
    </script>

    <script src="{{ URL::asset('cropper/cropper.js')}}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var avatar = document.getElementById('avatar');
            var image = document.getElementById('image');
            var input = document.getElementById('input');
            var $progress = $('.progress');
            var $progressBar = $('.progress-bar');
            var $alert = $('.alert');
            var $modal = $('#modal');
            var cropper;

            $('[data-toggle="tooltip"]').tooltip();

            input.addEventListener('change', function (e) {
                var files = e.target.files;
                var done = function (url) {
                    input.value = '';
                    image.src = url;
                    $alert.hide();
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById('crop').addEventListener('click', function () {
                var initialAvatarURL;
                var canvas;

                $modal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160
                    });

                    initialAvatarURL = avatar.src;
                    avatar.src = canvas.toDataURL();
                    $("#imageBaseCode").val(avatar.src);
                }
            });
        });
    </script>

@endsection



