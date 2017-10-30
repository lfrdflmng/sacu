@extends('layouts.admin')

@section('contenido')
<div class="content-box">
    <div class="row">
        <div class="col-sm-12">
            <div class="element-wrapper">
                <!--div class="os-tabs-w mx-4">
                    <div class="os-tabs-controls">
                        <ul class="nav nav-tabs upper">
                            <li class="nav-item"><a aria-expanded="false" class="nav-link" data-toggle="tab" href="#tab_overview"> Item 1</a></li>
                            <li class="nav-item"><a aria-expanded="false" class="nav-link" data-toggle="tab" href="#tab_sales"> Item 2</a></li>
                            <li class="nav-item"><a aria-expanded="false" class="nav-link" data-toggle="tab" href="#tab_sales"> Item 3</a></li>
                            <li class="nav-item"><a aria-expanded="true" class="nav-link active" data-toggle="tab" href="#tab_sales"> Item 4</a></li>
                        </ul>
                        <ul class="nav nav-pills smaller hidden-md-down">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#"> Hoy</a></li>
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#"> 7 Días</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#"> 14 Días</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#"> Mes Pasado</a></li>
                        </ul>
                    </div>
                </div-->

                <h6 class="element-header">Dashboard</h6>

                <div class="element-content">
                    <div class="row">
                        @component('componentes.contador')
                            @slot('titulo', __('estudiante.titulo_plural'))
                            {{--@slot('fuente', 'estudiante')--}}
                            @slot('total', $total['estudiante'])
                            @slot('clases_icono', 'os-icon os-icon-ui-90')
                        @endcomponent

                        @component('componentes.contador')
                            @slot('titulo', __('carrera.titulo_plural'))
                            {{--@slot('fuente', 'carrera')--}}
                            @slot('total', $total['carrera'])
                            @slot('clases_icono', 'os-icon os-icon-ui-44')
                        @endcomponent

                        @component('componentes.contador')
                            @slot('titulo', __('materia.titulo_plural'))
                            {{--@slot('fuente', 'materia')--}}
                            @slot('total', $total['materia'])
                            @slot('clases_icono', 'os-icon os-icon-ui-34')
                        @endcomponent

                        @component('componentes.contador')
                            @slot('titulo', __('profesor.titulo_plural'))
                            {{--@slot('fuente', 'profesor')--}}
                            @slot('total', $total['profesor'])
                            @slot('clases_icono', 'os-icon os-icon-cv-2')
                        @endcomponent
                    </div>
                </div>

                <h6 class="element-header">&nbsp;</h6>

                <div class="row">
                    <div class="col-md-2 col-xl-2">
                        <div class="element-wrapper">
                            <div class="element-box">
                                @component('componentes.graficas.dona')

                                @endcomponent
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-xl-6">
                        <div class="element-box">
                            <div class="padded">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left"><span>Carrera Uno</span><span class="positive"></span></div>
                                        <div class="bar-label-right"><span class="info">72/123</span></div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%">
                                        <div class="bar-level-2" style="width: 60%">
                                            <div class="bar-level-3" style="width: 20%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left"><span>Carrera Dos</span><span class="negative"></span></div>
                                        <div class="bar-label-right"><span class="info">162/412</span></div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%">
                                        <div class="bar-level-2" style="width: 40%">
                                            <div class="bar-level-3" style="width: 33%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left"><span>Carrera Tres</span><span class="positive"></span></div>
                                        <div class="bar-label-right"><span class="info">78/132</span></div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%">
                                        <div class="bar-level-2" style="width: 80%">
                                            <div class="bar-level-3" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden-lg-down col-xl-4">
                        <div class="element-box-tp">
                            <div class="profile-tile">
                                <div class="profile-tile-box">
                                    <div class="pt-avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                    <div class="pt-user-name">Persona Uno<br><span class="text-muted">V-12345678</span></div>
                                </div>
                                <div class="profile-tile-meta">
                                    <ul>
                                        <li>Carrera:<strong>Carrera Uno</strong></li>
                                        <li>Año:<strong>2</strong></li>
                                        <li>Promedio:<strong>9</strong></li>
                                    </ul>
                                    <div class="pt-btn"><a class="btn btn-secondary btn-sm" href="#">Ver más</a></div>
                                </div>
                            </div>

                            <div class="profile-tile">
                                <div class="profile-tile-box">
                                    <div class="pt-avatar-w"><img alt="" src="img/avatar2.jpg"></div>
                                    <div class="pt-user-name">Persona Dos<br><span class="text-muted">V-12345678</span></div>
                                </div>
                                <div class="profile-tile-meta">
                                    <ul>
                                        <li>Carrera:<strong>Carrera Dos</strong></li>
                                        <li>Año:<strong>12</strong></li>
                                        <li>Promedio:<strong>8</strong></li>
                                    </ul>
                                    <div class="pt-btn"><a class="btn btn-secondary btn-sm" href="#">Ver más</a></div>
                                </div>
                            </div>

                            <div class="profile-tile hidden-md">
                                <div class="profile-tile-box">
                                    <div class="pt-avatar-w"><img alt="" src="img/avatar3.jpg"></div>
                                    <div class="pt-user-name">Persona Tres<br><span class="text-muted">V-12345678</span></div>
                                </div>
                                <div class="profile-tile-meta">
                                    <ul>
                                        <li>Carrera:<strong>Carrera Dos</strong></li>
                                        <li>Tickets:<strong>12</strong></li>
                                        <li>Promedio:<strong>7</strong></li>
                                    </ul>
                                    <div class="pt-btn"><a class="btn btn-secondary btn-sm" href="#">Ver más</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section ('script')
<script type="text/javascript" src="{!! URL::asset('js/componentes/contador.js') !!}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        if ($('#donutChart').length) {
            const donutChart = $('#donutChart');

            // donut chart data
            let data = {
                labels: ['Masculino', 'Femenino'],
                datasets: [{
                    data: [{!! $estudiantes[1] !!}, {!! $estudiantes[0] !!}],
                    backgroundColor: ['#6896f9', '#f06292'],
                    hoverBackgroundColor: ['#6896f9', '#f06292'],
                    borderWidth: 0
                }]
            };

            // -----------------
            // init donut chart
            // -----------------
            new Chart(donutChart, {
                type: 'doughnut',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    animation: {
                        animateScale: false
                    },
                    cutoutPercentage: 80
                }
            });
        }
    });
</script>
@endsection