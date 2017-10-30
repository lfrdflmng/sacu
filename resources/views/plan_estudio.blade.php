@extends('layouts.admin')

@section('css')
<link href="{!! URL::asset('css/componentes/panel-lateral.css') !!}" rel="stylesheet">
<link href="{!! URL::asset('css/checkbox.min.css') !!}" rel="stylesheet">
<style type="text/css">
    /* elementos arrastrables */

    .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        /*max-width: 600px;*/
        list-style: none;
        font-size: 13px;
        line-height: 20px;
    }

    .dd-list {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dd-list .dd-list {
        padding-left: 30px;
    }

    .dd-collapsed .dd-list {
        display: none;
    }

    .dd-item,
    .dd-empty,
    .dd-placeholder {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 20px;
        font-size: 13px;
        line-height: 20px;
        cursor: default;
    }

    .dd-handle {
        display: block;
        height: 30px;
        margin: 5px 0;
        padding: 5px 10px;
        color: #333;
        text-decoration: none;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .dd-handle:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-item > button {
        display: block;
        position: relative;
        cursor: pointer;
        float: left;
        width: 25px;
        height: 20px;
        margin: 5px 0;
        padding: 0;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 0;
        background: transparent;
        font-size: 12px;
        line-height: 1;
        text-align: center;
        font-weight: bold;
    }

    .dd-item > button:before {
        content: '+';
        display: block;
        position: absolute;
        width: 100%;
        text-align: center;
        text-indent: 0;
    }

    .dd-item > button[data-action="collapse"]:before {
        content: '-';
    }

    .dd-placeholder,
    .dd-empty {
        margin: 5px 0;
        padding: 0;
        min-height: 30px;
        background: #f2fbff;
        border: 1px dashed #b6bcbf;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-empty {
        border: 1px dashed #bbb;
        /*min-height: 100px;
        background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);*/
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel {
        position: absolute;
        pointer-events: none;
        z-index: 9999;
        -webkit-transform: rotate(1deg);
        -moz-transform: rotate(1deg);
        -ms-transform: rotate(1deg);
        -o-transform: rotate(1deg);
        transform: rotate(1deg);
    }

    .dd-dragel > .dd-item .dd-handle {
        margin-top: 0;
    }

    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
    }

    .dd-hover > .dd-handle {
        background: #2ea8e5 !important;
    }

    .dd-item.error .dd-handle {
        border: 1px solid red;
    }

    .dd-item.activo .dd-handle {
        background: #0271d0 !important;
        color: #fff;
        border: 0;
    }

    /*.dd-item[data-tipo=anualidad] {
        font-weight: bold;
    }*/

    /* lista prerrequisitos */

    .nestable-prerrequisitos .dd-item[data-nivel="0"] /*> .dd-handle*/ {
        display: none;
    }

    .nestable-prerrequisitos .dd-item[data-nivel="1"] /*> .dd-handle*/ {
        /*background: none;
        border: 0;
        pointer-events: none;
        font-weight: normal;
        color: #777;*/
        display: none;
    }

    .nestable-prerrequisitos .dd-item[data-nivel="2"] > .dd-handle {
        background: #fafafa none;
    }

    .nestable li.prerrequisito {
        margin-left: 20px;
        padding: 4px;
        font-size: 14px;
    }

    .nestable li.prerrequisito:hover {
        background-color: #eee;
        cursor: pointer;
    }

    .nestable li.prerrequisito.editando {
        -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, .2);
        box-shadow: 0 5px 20px rgba(0, 0, 0, .2);
    }

    div.editando li:not(.editando) {
        opacity: .3;
    }

    .nestable li.resaltado .dd-handle {
        background-color: #ddd !important;
    }


    /* vista árbol */

    .vista-arbol .node {
        cursor: pointer;
    }

    .vista-arbol .node circle {
        fill: #fff;
        stroke: steelblue;
        stroke-width: 1px;
    }

    .vista-arbol .node text {
        font: 10px sans-serif;
    }

    .vista-arbol .link {
        fill: none;
        stroke: #ccc;
        stroke-width: 1px;
    }


    /* prerrequisitos */

    .frm-prerrequisito .btn-acciones-editar {
        display: none;
    }

    .frm-prerrequisito.editar .btn-acciones-editar {
        display: inline-flex;
    }

    .frm-prerrequisito .btn-agregar .texto:after {
        content: "{!! __('global.add') !!}";
    }

    .frm-prerrequisito.editar .btn-agregar .texto:after {
        content: "{!! __('global.save') !!}";
    }


    /* finalizado */

    .finalizado .btn-finalizar,
    .finalizado .panel-lateral,
    .finalizado .btn-ok {
        display: none;
    }
</style>
@endsection


@section('contenido')
<!-- RASTRO -->
<ul class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">{!! __('global.home') !!}</a>
    </li>
    <li class="breadcrumb-item">
        <span>{!! __($fuente . '.titulo_plural') !!}</span>
    </li>
</ul>
<!-- /RASTRO -->

<!-- CONTENIDO PRINCIPAL -->
<div class="content-box">
    <div class="element-wrapper">

        @component('componentes.barra-accion-superior', ['fuente' => $fuente])
            @slot('opciones_adicionales_seleccion', [
                ['id' => 'btn_ver_estructura', 'titulo' => __('plan_estudio.ver_estructura')],
            ])
        @endcomponent

        <div class="element-box tabla-contenedor" style="display:none"> {{-- Se muestra luego cuando haya cargado con Javascript --}}
            @component('componentes.tabla', ['fuente' => $fuente])
                @slot('configuracion_columnas')
                    {
                        'targets': [5], //fecha
                        'render': function(data) { return moment(data).format('YYYY'); }
                    },
                    {
                        'targets': [7], //status
                        'render': function(data) { return data == {!! \App\PlanEstudio::FINALIZADO !!} ? '<i class="fa fa-check"></i>' : ''; }
                    }
                @endslot
                @slot('funcion_doble_clic', 'eventoDobleClicItem')
            @endcomponent
        </div>

    </div>
</div>
<!-- /CONTENIDO PRINCIPAL -->

<!-- MODAL "NUEVO REGISTRO" -->
@component('componentes.modal', ['id' => 'modal_nuevo_registro'])
    @slot('titulo', __('global.new'))
    @slot('posicion', 'derecha')

    <!-- formulario -->
    @component('componentes.formulario')
        @include('formularios.' . $fuente . '-crear')
    @endcomponent
@endcomponent
<!-- /MODAL "NUEVO REGISTRO" -->

<!-- MODAL "EDITAR REGISTRO" -->
@component('componentes.modal', ['id' => 'modal_editar_registro'])
    @slot('titulo', __('global.edit'))
    @slot('posicion', 'derecha')

    <!-- formulario -->
    @component('componentes.formulario')
        @include('formularios.' . $fuente . '-editar')
    @endcomponent
@endcomponent
<!-- /MODAL "EDITAR REGISTRO" -->

<!-- MODAL "EDITAR ESTRUCTURA" -->
@component('componentes.modal', ['id' => 'modal_editar_estructura'])
    @slot('titulo', __('plan_estudio.estructura'))
    @slot('posicion', 'centro')
    @slot('botones_adicionales')
    <div class="col">
        <button type="button" id="btn_finalizar_estructura" class="btn btn-default btn-finalizar disabled">
            <i class="fa fa-fw fa-unlock-alt"></i> {!! strtoupper(__('plan_estudio.cerrar_plan_estudio')) !!}
        </button>
    </div>
    @endslot

    <!-- formulario guardar -->
    @component('componentes.formulario')
        @slot('id', 'frm_guardar_estructura')
        @slot('funcion_pre_enviar', 'verificarEstructuraAntesDeEnviar')
        <input type="hidden" name="id">
        <input type="hidden" name="estructura">
        <input type="hidden" name="prerrequisitos">
        <input type="hidden" name="finalizar" value="0">
        <input type="hidden" name="_accion" value="guardarEstructura">
    @endcomponent

    @component('componentes.pestanas')
        @slot('opciones',[
            'pestana_estructura' => '<i class="fa fa-fw fa-align-right"></i> ' . __('plan_estudio.tipo_estructura'),
            'pestana_vista' => '<i class="fa fa-fw fa-share-alt"></i> ' . __('plan_estudio.tipo_navegacion'),
            'pestana_prerrequisitos' => '<i class="fa fa-fw fa-sort-numeric-asc"></i> ' . __('plan_estudio.tipo_prerrequisitos'),
            'pestana_tabla' => '<i class="fa fa-fw fa-file-text-o"></i> ' . __('plan_estudio.tipo_tabla')
        ])
    @endcomponent

    <!-- pestaña estructura -->
    <div id="pestana_estructura">
        <div class="row todo-app-w">

            <!-- estructura -->
            <div class="col-md-8 col-sm-12">
                <div id="contenedor_estructura">
                    <div class="dd nestable nestable-destino">
                        <!--i class="text-muted">Arrastrar aquí</i-->
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1" data-nivel="0">
                                <div class="dd-handle">I</div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- panel lateral -->
            <div class="col-md-4 col-sm-12">
                @component('componentes.panel-lateral')
                    @slot('titulo', __('global.add'))
                    @slot('secciones', [
                        [
                            'nombre' => 'anualidad',
                            'titulo' => __('anualidad.titulo')
                        ],
                        [
                            'nombre' => 'modalidad',
                            'titulo' => __('modalidad.titulo')
                        ],
                        [
                            'nombre' => 'materia',
                            'titulo' => __('materia.titulo')
                        ]
                    ])

                    @slot('anualidad')
                        <div class="dd nestable nestable-fuente" data-fuente="anualidad" data-nestable="0">
                            <ol class="dd-list"></ol>
                        </div>
                    @endslot

                    @slot('modalidad')
                        <div class="dd nestable nestable-fuente" data-fuente="modalidad" data-nestable="0">
                            <ol class="dd-list"></ol>
                        </div>
                    @endslot

                    @slot('materia')
                        <div class="input-group form-material">
                            <input type="text" class="form-control input-buscador" data-fuente="{!! $fuente or '' !!}" placeholder="{!! __('global.search') !!}..." autocomplete="off" value="">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                        <div class="dd nestable nestable-fuente" data-fuente="materia" data-nestable="0">
                            <ol class="dd-list"></ol>
                        </div>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>

    <!-- pestaña vista árbol -->
    <div id="pestana_vista" class="vista-arbol hidden" data-fn="seleccionVistaArbol">
        <!-- svg -->
    </div>

    <!-- pestaña prerequisitos -->
    <div id="pestana_prerrequisitos" class="hidden" data-fn="seleccionVistaPrerrequsitos">
        <div class="row todo-app-w">
            <div class="col-md-8 col-sm-12">
                <div id="contenedor_prerrequisitos">
                    <div class="dd nestable nestable-destino nestable-prerrequisitos">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1" data-nivel="0">
                                <div class="dd-handle">I</div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                @component('componentes.panel-lateral')
                    @slot('titulo', __('global.add'))
                    @slot('secciones', [
                        [
                            'nombre' => 'creditos',
                            'titulo' => __('materia.unidades_credito')
                        ],
                        [
                            'nombre' => 'materias',
                            'titulo' => __('materia.titulo')
                        ]
                    ])

                    @slot('creditos')
                        <form id="frm_prerrequisito_uc" class="frm-prerrequisito form-material shaded" autocomplete="off">
                            @component('componentes.inputs.numero', ['nombre' => 'valor'])
                                @slot('id', 'pre_uc_cantidad')
                                @slot('etiqueta', __('materia.uc'))
                                @slot('placeholder', __('plan_estudio.cantidad_uc'))
                            @endcomponent

                            @component('componentes.inputs.checkbox', ['nombre' => 'opcional'])
                                @slot('id', 'pre_uc_opcional')
                            @endcomponent

                            <input type="hidden" name="id" value="">

                            <div class="text-right">
                                <div class="btn-group btn-acciones-editar mr-2" role="group">
                                    <button type="button" class="btn btn-default btn-cancelar"><i class="fa fa-fw fa-window-close"></i></button>
                                    <button type="button" class="btn btn-default btn-quitar"><i class="fa fa-fw fa-trash"></i></button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-agregar btn-secondary">
                                        <span class="texto"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endslot

                    @slot('materias')
                        <form id="frm_prerrequisito_materia" class="frm-prerrequisito form-material shaded" autocomplete="off">
                            @component('componentes.inputs.seleccion', ['nombre' => 'valor'])
                                @slot('id', 'pre_id_materia')
                                @slot('etiqueta', __('materia.titulo'))
                            @endcomponent

                            @component('componentes.inputs.checkbox', ['nombre' => 'opcional'])
                                @slot('id', 'pre_materia_opcional')
                            @endcomponent

                            <input type="hidden" name="id" value="">

                            <div class="text-right">
                                <div class="btn-group btn-acciones-editar mr-2" role="group">
                                    <button type="button" class="btn btn-default btn-cancelar"><i class="fa fa-fw fa-window-close"></i></button>
                                    <button type="button" class="btn btn-default btn-quitar"><i class="fa fa-fw fa-trash"></i></button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-agregar btn-secondary">
                                        <span class="texto"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>

    <!-- pestaña tabla / documento -->
    <div id="pestana_tabla" data-fn="seleccionVistaDocumento">
        <div class="row mb-1">
            <div class="col-sm-12 text-right">
                <button type="button" id="btn_imprimir_documento" class="btn btn-default">
                    <i class="fa fa-fw fa-print"></i>
                </button>
            </div>
        </div>

        <div id="tabla_impresion"></div>
    </div>
@endcomponent
<!-- /MODAL "EDITAR ESTRUCTURA" -->

<form id="frm_cargar_estructura" action="{!! URL::route('get') !!}" method="get" autocomplete="off">
    <input type="hidden" name="id">
    <input type="hidden" name="_fuente" value="PlanEstudio">
    <input type="hidden" name="_accion" value="cargarEstructura">
    <input type="hidden" name="anualidad" value="1">
    <input type="hidden" name="modalidad" value="1">
    <input type="hidden" name="materia" value="1">
</form>

<form id="frm_cargar_materias" action="{!! URL::route('get') !!}" method="get">
    <input type="hidden" name="_fuente" value="Materia">
    <input type="hidden" name="_accion" value="arreglo">
</form>
@endsection


@section('script')
<script type="text/javascript" src="{!! URL::asset('js/jquery.nestable.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/componentes/lista-anidada.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/d3.v3.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/hoverintent.min.js') !!}"></script>
<script type="text/javascript" src="{!! URL::asset('js/componentes/panel-lateral.js') !!}"></script>
<script type="text/javascript">
    /**
     * variables globales
     */
    let _lista_estructura;
    let _lista_prerrequisitos;
    let _prerrequisitos; //instancia de la clase prerrequisitos
    let _materias = null;


    /**
     * Ata los eventos de botones
     */
    function accionesClic() {
        const $modal = $('#modal_editar_estructura');

        //modal editar estructura
        $modal.find('#btn_finalizar_estructura').click(function() {
            finalizarEstructura();
        });

        /*$modal.find('.nav-link[data-destino=pestana_vista]').click(function() {
            seleccionVistaArbol();
        });*/

        /*$modal.find('.nav-link[data-destino=pestana_prerrequisitos]').click(function() {
            seleccionVistaPrerrequsitos();
        });*/

        /*$modal.find('.nav-link[data-destino=pestana_tabla]').click(function() {
            seleccionVistaDocumento();
        });*/

        $modal.find('#btn_imprimir_documento').click(function() {
            const contenido = $modal.find('#tabla_impresion');
            let ventana = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            ventana.document.write('<link href="{!! URL::asset('css/main.css') !!}" rel="stylesheet">');
            ventana.document.write(`
                <style type="text/css">
                    body { background: #fff !important; padding: 10px; }
                    body:before { display: none !important; }
                </style>
            `);
            ventana.document.write(contenido.html());
            ventana.document.close();
            ventana.focus();
            ventana.print();
            ventana.close();
        });

        //opciones adicionales del menu

        //modal ver estructura
        $('#btn_ver_estructura').click(function() {
            const id = tabla_principal.idSeleccionado();

            if (id > 0) {
                //pestaña seleccionada por defecto
                seleccionarPestana($('.nav-link[data-destino=pestana_estructura]').parent());

                //realiza la solicitud y muestra el resultado
                cargarEstructura(id);
            }
        });
    }


    /**
     * Cuando se selecciona la pestaña Navegación de la estructura
     */
    function seleccionVistaArbol() {
        let json = {
            texto: '{!! __('plan_estudio.titulo') !!}',
            children: _lista_estructura.getJsonString({incluir_ids: false})//$contenedor.nestable('serialize', false)
        };
        inicializarVistaArbol(json);
    }


    /**
     * Cuando se selecciona la pestaña Prerrequsitos de la estructura
     */
    function seleccionVistaPrerrequsitos() {
        construirEstructuraPrerrequisitos(_lista_estructura.getJsonString(), false);
        cargarSelectMateriasPrerrequisitos();
        _prerrequisitos.mostrar();
    }


    /**
     * Cuando se selecciona la pestaña Documento de la estructura
     */
    function seleccionVistaDocumento() {
        construirEstructuraDocumento([
            '{!! __('plan_estudio.ano') !!}',
            '{!! __('modalidad.titulo') !!}',
            '{!! __('materia.titulo') !!}',
            '{!! __('materia.codigo') !!}',
            '{!! __('materia.uc') !!}',
            '{!! __('materia.ht') !!}',
            '{!! __('materia.hp') !!}',
            '{!! __('plan_estudio.tipo_prerrequisitos') !!}'
        ]);
    }


    /**
     * Agrega las materias al select de prerrequisitos
     */
    function cargarSelectMateriasPrerrequisitos() {
        const $select = $('#pre_id_materia');
        let $materias = $('#contenedor_prerrequisitos').find('li[data-tipo=materia]');
        let opciones_html = '';
        let $materia;
        $.each($materias, function(n,i) {
            $materia = $(i);
            opciones_html += '<option value="' + $materia.data('id') + '">';
            opciones_html += $materia.text();
            opciones_html += '</option>';
        });
        $select.html(opciones_html);
    }


    /**
     * Solicita la estructura del plan de estudio y llama el procedimiento para mostrarla
     */
    function cargarEstructura(id) {
        const $modal = $('#modal_editar_estructura');
        $modal.addClass('procesando');
        $modal.modal('show');

        //se bloquea mientras no se haya cargado los datos de las materias
        $modal.find('.nav-link[data-destino=pestana_tabla]').removeClass('disabled');

        id = parseInt(id);
        if (id) {
            const $frm = $('#frm_cargar_estructura');
            $frm.find('input[name=id]').val(id);

            $modal.find('.nestable-destino').html(barraProgreso());

            //realiza la solicitud via ajax
            enviarFormulario($frm, function(data) {

                //se guarda el id del plan de estudio en el formulario del modal
                $modal.find('#frm_guardar_estructura').find('input[name=id]').val(data['id_plan_estudio']);

                //crea el html para las listas de las categorías
                construirCategorias(data, $modal);

                //crea el html desde el json y lo muestra en el modal
                construirEstructura(data);

                //se apagan porque solo se solicitan cuando es la primera carga
                $frm.find('input[name=anualidad]').val(0);
                $frm.find('input[name=modalidad]').val(0);
                $frm.find('input[name=materia]').val(0);

                //oculta el botón 'finalizar' si ya ha está finalizado.
                //agregarClaseSoloSi($('#btn_finalizar_estructura'), 'hidden', typeof data['finalizado'] !== 'undefined' && data['finalizado']);
                agregarClaseSoloSi($modal, 'finalizado', typeof data['finalizado'] !== 'undefined' && data['finalizado']);

                $modal.removeClass('procesando');
            });

            if (_materias === null) {
                cargarMaterias();
            }
        }
    }


    /**
     * Hace una solicitud via ajax para traer los datos de las materias
     */
    function cargarMaterias() {
        const $frm = $('#frm_cargar_materias');

        enviarFormulario($frm, function(data) {
            if (data['ok'] == 1) {
                _materias = data['items'];
                $('#modal_editar_estructura').find('.nav-link[data-destino=pestana_tabla]').removeClass('disabled');
            }
        });
    }


    /**
     * Carga los textos de los elementos si no están presentes en el Json
     */
    function checkTextos(data) {
        let estructura;

        if (typeof data === 'string' && data.length) {
            estructura = window.JSON.parse(data);
        }
        else {
            estructura = data;
        }

        if (typeof estructura[0].texto === 'undefined') {
            _lista_estructura.establecerTextosNivel(0, window['_estructura_anualidad']);
            _lista_estructura.establecerTextosNivel(1, window['_estructura_modalidad']);
            _lista_estructura.establecerTextosNivel(2, window['_estructura_materia']);
        }
    }


    /**
     * Crea el html de la lista anidada según la data
     */
    function construirEstructura(data/*, $destino*/) {
        if (typeof data === 'object') {
            checkTextos(data['data_borrador']);

            _lista_estructura.construir(data['data_borrador']);

            if (typeof data['data_prerrequisitos_borrador'] !== 'undefined') {
                _prerrequisitos.setJson(data['data_prerrequisitos_borrador']);
            }
        }
    }


    /**
     * Crea los listados de las categorías
     */
    function construirCategorias(data, $modal) {
        let finalizado = typeof data['finalizado'] !== 'undefined' && data['finalizado'];

        //anualidad
        if (typeof data['anualidad'] !== 'undefined') {
            construirCategoria(data['anualidad'], 'anualidad', 0, false, $modal);
        }

        //modalidad
        if (typeof data['modalidad'] !== 'undefined') {
            construirCategoria(data['modalidad'], 'modalidad', 1, true, $modal);
        }

        //materia
        if (typeof data['materia'] !== 'undefined') {
            construirCategoria(data['materia'], 'materia', 2, false, $modal);
        }

        ListaAnidada.inicializarDragDrop($modal.find('.nestable-fuente'), {
            grupo: 1,
            profundidad: 1,
            eventoAlCambiar: verificarEstructura,
            permitirDragDrop: !finalizado
        });
    }


    /**
     * Crea el html de la lista anidada en prerrequisitos según la data
     */
    function construirEstructuraPrerrequisitos(data, mostrar_prerrequisitos) {
        if (typeof data === 'object') {
            _lista_prerrequisitos.construir(data);

            if (typeof mostrar_prerrequisitos !== 'boolean' || mostrar_prerrequisitos) {
                _prerrequisitos.mostrar();
            }
        }
    }


    /**
     * Construye el HTML para los elementos del filtro
     */
    function construirCategoria(items, nombre, nivel, fijo, $destino) {
        let html;
        let $holder = $destino.find('.nestable[data-fuente=' + nombre +']').find('ol');
        $holder.find('li').remove();
        window['_estructura_' + nombre] = [];
        for (let item in items) {
            if (items.hasOwnProperty(item)) {
                html = ListaAnidada.elementoHtml(item, items[item], nivel, nombre, fijo);
                $holder.append($(html));
                window['_estructura_' + nombre][item] = items[item];
            }
        }
    }


    /**
     * Construye el HTML de la tabla documento
     */
    function construirEstructuraDocumento(cabeceras) {
        const $contenedor = $('#tabla_impresion');

        if (_materias === null) {
            $contenedor.html(barraProgreso(1, undefined, {
                clases: 'bg-danger'
            }));
            return;
        }

        $contenedor.html(barraProgreso());

        const estructura = _lista_estructura.instancia.nestable('serialize');

        /*let html = `
        <table class="table table-bordered" style="margin: 0 auto; width: 80%">
            <tbody>`;*/
        let tbl = document.createElement('table');
        tbl.setAttribute('class', 'table table-bordered');
        tbl.setAttribute('style', 'margin: 0 auto; width: 80%');

        //cabecera
        {
            let thead = document.createElement('thead');

            let plan_seleccionado = tabla_principal.itemSeleccionado();
            let tr_plan = document.createElement('tr');
            let td_carrera = document.createElement('td');
            let span_ano = document.createElement('span');

            span_ano.textContent = moment(plan_seleccionado[5]).format('YYYY');
            td_carrera.innerHTML = plan_seleccionado[6].toUpperCase();

            span_ano.setAttribute('class', 'float-right');
            td_carrera.setAttribute('colSpan', '8');

            td_carrera.appendChild(span_ano);
            tr_plan.appendChild(td_carrera);

            thead.appendChild(tr_plan);

            let titulos;
            if (typeof cabeceras === 'undefined') {
                titulos = ['Año', 'Modalidad', 'Materia', 'Código', 'UC', 'HT', 'HP', 'Prelaciones'];
            }
            else {
                titulos = cabeceras;
            }
            let tr_hread = document.createElement('tr');
            for (let titulo of titulos) {
                let th = document.createElement('th');
                th.setAttribute('class', 'text-center');
                th.textContent = titulo;
                tr_hread.appendChild(th);
            }
            thead.appendChild(tr_hread);

            tbl.appendChild(thead);
        }

        //contenido
        let tbody = document.createElement('tbody');

        let td_anualidad;
        let td_modalidad;

        for (let anualidad of estructura) {
            let inicio_anualidad = true;

            if (typeof anualidad.children === 'object') {

                for (let modalidad of anualidad.children) {
                    let inicio_modalidad = true;

                    if (typeof modalidad.children === 'object') {

                        for (let materia of modalidad.children) {
                            let tr = document.createElement('tr');

                            //buscando los detalles de la materia
                            for (let data of _materias) {

                                if (data.id == materia.id) {

                                    //anualidad
                                    if (inicio_anualidad) {
                                        let total_materias_anualidad = 0;
                                        for (let mod of anualidad.children) {
                                            if (typeof mod.children === 'object') {
                                                for (let mat in mod.children) {
                                                    total_materias_anualidad++;
                                                }
                                            }
                                        }

                                        td_anualidad = document.createElement('td');
                                        td_anualidad.setAttribute('class', 'align-middle text-center');
                                        td_anualidad.textContent = anualidad.texto;
                                        td_anualidad.setAttribute('rowSpan', total_materias_anualidad.toString());
                                        tr.appendChild(td_anualidad);
                                    }

                                    //modalidad
                                    if (inicio_modalidad) {
                                        td_modalidad = document.createElement('td');
                                        td_modalidad.setAttribute('class', 'align-middle text-center');
                                        td_modalidad.textContent = modalidad.texto;
                                        td_modalidad.setAttribute('rowSpan', modalidad.children.length);
                                        tr.appendChild(td_modalidad);
                                    }

                                    //datos materia

                                    let td_materia = document.createElement('td');
                                    let td_codigo = document.createElement('td');
                                    let td_uc = document.createElement('td');
                                    let td_ht = document.createElement('td');
                                    let td_hp = document.createElement('td');
                                    let td_prelaciones = document.createElement('td');

                                    td_materia.textContent = materia.texto;
                                    td_codigo.textContent = data.abreviatura;
                                    td_uc.textContent = data.uc;
                                    td_ht.textContent = data.ht;
                                    td_hp.textContent = data.hp;
                                    td_prelaciones.textContent = _prerrequisitos.listaDeMateria(materia.id, _materias, '{!! __('materia.uc') !!}').join(', ');

                                    td_uc.setAttribute('class', 'text-center');
                                    td_ht.setAttribute('class', 'text-center');
                                    td_hp.setAttribute('class', 'text-center');

                                    tr.appendChild(td_materia);
                                    tr.appendChild(td_codigo);
                                    tr.appendChild(td_uc);
                                    tr.appendChild(td_ht);
                                    tr.appendChild(td_hp);
                                    tr.appendChild(td_prelaciones);

                                    /*html += `
                                        <tr>
                                            <td>{materia.texto}</td>
                                            <td>{materia.abreviatura}</td>
                                            <td>{materia.uc}</td>
                                            <td>{materia.ht}</td>
                                            <td>{materia.hp}</td>
                                            <td>something</td>
                                        </tr>`;*/
                                    break;
                                }
                            }

                            tbody.appendChild(tr);
                            inicio_modalidad = false;
                            inicio_anualidad = false;
                        }
                    }
                }
            }
        }

        tbl.appendChild(tbody);

        $contenedor.html(tbl);
    }


    /**
     * Verifica los niveles de la estructura final y les coloca la clase 'error' a los items no válidos
     */
    function verificarEstructura($el) {
        if (typeof $el === 'undefined') {
            $el = $('#contenedor_estructura').find('li');
        }
        else {
            $el = $el.parent().find('li');
        }

        //solo verifica en la lista destino y no en las listas fuentes
        let $destino = $el.eq(0).closest('.nestable-destino');
        if ($destino.length) {
            let $i;
            $.each($el, function (n, i) {
                $i = $(i);
                agregarClaseSoloSi($i, 'error', $i.parents('ol').length !== parseInt($i.attr('data-nivel')) + 1);
            });
        }

        //verifica que todas las modalidades tengan materias (puede finalizar)
        let puede_finalizar = true;
        $el = $destino.find('li[data-nivel=1]');
        $.each($el, function(n, i) {
            $i = $(i);
            //si la modalidad no tiene hijos (materias), no se puede finalizar
            if (!$i.find('li').length) {
                puede_finalizar = false;
                return false;
            }
        });

        //TODO: verificar que no haya materias duplicadas

        //activa o desactiva el botón 'finalizar'
        agregarClaseSoloSi($('#btn_finalizar_estructura'), 'disabled', !puede_finalizar);

        verificarPrerrequisitos();
    }


    /**
     * Verifica los prerrequisitos y les coloca la clase 'error' a los items no válidos
     */
    function verificarPrerrequisitos() {
        //const $contenedor = $('#contenedor_prerrequisitos');
        //TODO
    }


    /**
     * Guarda y bloquea la estructura del plan de estudio
     */
    function finalizarEstructura() {
        confirmar('{!! __('plan_estudio.confirmar_finalizar_estructura') !!}', function() {
            let $frm = $('#frm_guardar_estructura');
            $frm.find('input[name=finalizar]').val('1');
            enviarFormulario($frm, function(data) {
                if (data['ok'] == 1) {
                    listoEnviarFormulario(data, $frm);
                }
            }, undefined, undefined, undefined, undefined, function() {
                $frm.find('input[name=finalizar]').val('0');
            });
        });
    }


    /**
     * Evento que se ejecuta cuando se hace doble clic en un TR de la tabla;
     * se especifica en el slot 'funcion_doble_clic' del componente tabla.
     *
     * Cuando se hace doble clic se abre el modal y se carga la estructura del plan de estudio.
     */
    function eventoDobleClicItem($tr) {
        //animación opcional
        agregarClaseTemp($tr, 'animated pulse');

        //id del elemento seleccionado
        let id = $tr.closest('table').DataTable().row($tr).data()[1];

        //pestaña seleccionada por defecto
        seleccionarPestana($('.nav-link[data-destino=pestana_estructura]').parent());

        //realiza la solicitud y muestra el resultado
        cargarEstructura(id);
    }


    /**
     * Proceso de verificación de la estructura del plan de estudio.
     * Si hay errores se cancela el proceso
     */
    function verificarEstructuraAntesDeEnviar($frm) {
        const $contenedor = $('#contenedor_estructura').find('.nestable');
        if ($contenedor.find('.error').length) {
            mostrarMensajeError('{!! __('plan_estudio.error_estructura') !!}');
            return false;
        }
        $frm.find('input[name=estructura]').val(_lista_estructura.getJsonString() /*window.JSON.stringify( $contenedor.nestable('serialize') )*/);
        $frm.find('input[name=prerrequisitos]').val(_prerrequisitos.getJsonString());
        return true;
    }


    /**
     * Inicializa las acciones de los paneles laterales en el modal Estructura
     */
    function inicializarPanelesLaterales() {
        new PanelLateral({
            contenedor: $('#modal_editar_estructura')
        });
    }


    /**
     * Inicializa el objeto para la lista anidada de la estructura del plan de estudio
     */
    function inicializarListaAnidadaEstructura() {
        _lista_estructura = new ListaAnidada({
            contenedor: $('#contenedor_estructura').find('.nestable'),
            niveles: [
                'anualidad',
                { nombre: 'modalidad', fijo: true },
                'materia'
            ],
            eventoAlCambiar: verificarEstructura
        });
    }


    /**
     * Inicializa el objeto para la lista de las materias en la ficha de prerrequisitos
     */
    function inicializarListaAnidadaPrerrequisitos() {
        const $contenedor = $('#contenedor_prerrequisitos');

        _lista_prerrequisitos = new ListaAnidada({
            contenedor: $contenedor.find('.nestable'),
            niveles: [
                'anualidad',
                'modalidad',
                'materia'
            ],
            eventoAlCambiar: verificarEstructura,
            anidar: false,
            permitirDragDrop: false,
            seleccionable: true,
            eventoAlSeleccionar: !$contenedor.closest('.modal').hasClass('finalizado') ? Prerrequisitos.seleccionarMateria.bind({instancia: _prerrequisitos}) : null
        });
    }


    /**
     * Inicializa el objeto que maneja los prerrequisitos
     */
    function inicializarPrerrequisitos() {
        _prerrequisitos = new Prerrequisitos({
            contenedor: $('#contenedor_prerrequisitos'),
            formulario_uc: $('#frm_prerrequisito_uc'),
            formulario_materia: $('#frm_prerrequisito_materia'),
            msj_err_materia_no_seleccionada: '{!! __('plan_estudio.materia_no_seleccionada') !!}',
            msj_err_valor_no_ingresado: '{!! __('plan_estudio.no_se_ha_ingresado_valores') !!}'
        });
    }


    /**
     * Clase para manejar los prerrequisitos de las materias
     */
    class Prerrequisitos {

        constructor(opciones) {
            this.items = [];

            this.contenedor = opciones['contenedor'];
            this.formulario_uc = opciones['formulario_uc'];
            this.formulario_materia = opciones['formulario_materia'];
            this.texto_uc = '<?php echo __('materia.uc'); ?>';
            this.texto_materia = '<?php echo __('materia.titulo'); ?>';
            this.msj_err_materia_no_seleccionada = opciones['msj_err_materia_no_seleccionada'];
            this.msj_err_valor_no_ingresado = opciones['msj_err_valor_no_ingresado'];

            if (typeof opciones['items'] === 'object' && opciones['items'] !== null) {
                this.items = opciones['items'];
            }

            //UNIDADES DE CREDITO

            //agregar/guardar
            this.formulario_uc.find('.btn-agregar').click(this.procesarAgregarCredito.bind(this));

            //quitar
            let fn_quitar_credito = this.procesarQuitarCredito.bind(this);
            this.formulario_uc.find('.btn-quitar').click(function() {
                let id = $(this).closest('form').find('input[name=id]').val();
                fn_quitar_credito(id);
            });

            //cancelar editar
            this.formulario_uc.find('.btn-cancelar').click(this.restaurarFormularioUc.bind(this));

            //MATERIAS

            //agregar/guardar
            this.formulario_materia.find('.btn-agregar').click(this.procesarAgregarMateria.bind(this));

            //quitar
            this.formulario_materia.find('.btn-quitar').click(function() {
                let id = $(this).closest('form').find('input[name=id]').val();
                fn_quitar_credito(id);
            });

            //cancelar editar
            this.formulario_materia.find('.btn-cancelar').click(this.restaurarFormularioMateria.bind(this));
        }


        /**
         * Acción cuando se hace clic en el botón Agregar del formulario UC
         */
        procesarAgregarCredito() {
            let $pre_id = this.formulario_uc.find('input[name=id]');
            let $item = this.contenedor.find('.dd-item.activo');

            //si no se está editando y no hay una materia seleccionada...
            if (!(parseInt($pre_id.val()) > 0)) {
                if (!$item.length) {
                    mostrarMensajeError(this.msj_err_materia_no_seleccionada);
                    return;
                }
            }

            const $frm = this.formulario_uc;
            let id = $item.data('id');
            let $uc = $frm.find('input[name=valor]');
            let $opcional = $frm.find('input[name=opcional]');

            //si hay una cantidad válida (mayor a cero)
            if ($uc.length && parseInt($uc.val()) > 0) {
                this.agregar(id, {
                    id: $pre_id.val(),
                    tipo: 0,
                    valor: parseInt($uc.val()) || 0,
                    opcional: $opcional.is(':checked')
                });

                //limpia los campos
                this.restaurarFormularioUc();
            }
            else {
                mostrarMensajeError(this.msj_err_valor_no_ingresado);
            }
        }


        /**
         * Acción cuando se hace clic en el botón Agregar del formulario Materia
         */
        procesarAgregarMateria() {
            let $pre_id = this.formulario_materia.find('input[name=id]');
            let $item = this.contenedor.find('.dd-item.activo');

            //si no se está editando y no hay una materia seleccionada...
            if (!(parseInt($pre_id.val()) > 0)) {
                if (!$item.length) {
                    mostrarMensajeError(this.msj_err_materia_no_seleccionada);
                    return;
                }
            }

            const $frm = this.formulario_materia;
            let id = $item.data('id');
            let $materia = $frm.find('select[name=valor]');
            let $opcional = $frm.find('input[name=opcional]');

            //cuando se ha seleccionado una materia
            if ($materia.length && parseInt($materia.val()) > 0) {

                //si la materia seleccionada no es la misma a la que se le va a asignar la prelación
                if ($materia.val() != id) {
                    this.agregar(id, {
                        id: $pre_id.val(),
                        tipo: 1,
                        valor: parseInt($materia.val()) || 0,
                        opcional: $opcional.is(':checked')
                    });

                    //limpia los campos
                    this.restaurarFormularioMateria();
                }
                else {
                    //mostrarMensajeError('<?php echo __('plan_estudio.materia_seleccionada_igual_materia_prelacion'); ?>');
                    agregarClaseTemp($materia.closest('.form-group'), 'animated shake');
                }
            }
            else {
                mostrarMensajeError(this.msj_err_valor_no_ingresado);
            }
        }


        /**
         * Acción cuando se hace clic en el botón Quitar
         */
        procesarQuitarCredito(id) {
            this.eliminar(id);
            this.restaurarFormularioUc();
        }


        /**
         * Limpia el formulario de prerrequisitos para UC
         */
        restaurarFormularioUc() {
            const $frm = this.formulario_uc;
            $frm.find('input[name=valor]').val('');
            $frm.find('input[name=opcional]').prop('checked', false);
            $frm.find('input[name=id]').val('');
            $frm.removeClass('editar');

            this.restaurarLista();
        }


        /**
         * Limpia el formulario de prerrequisitos para materia
         */
        restaurarFormularioMateria() {
            const $frm = this.formulario_materia;
            $frm.find('select[name=valor]').val('').change();
            $frm.find('input[name=opcional]').prop('checked', false);
            $frm.find('input[name=id]').val('');
            $frm.removeClass('editar');

            this.restaurarLista();
        }


        /**
         * Quita las clases de edición
         */
        restaurarLista() {
            Prerrequisitos.restaurarListaEnContenedor(this.contenedor);
        }


        static restaurarListaEnContenedor($contenedor) {
            $contenedor.removeClass('editando');
            $contenedor.find('.editando').removeClass('editando');
        }


        /**
         * Registra un prerrequisito a la variable this.items
         */
        agregar(id_materia, params) {
            let indice = null;
            for (let key in this.items) {
                if (this.items[key].id === id_materia) {
                    indice = key;
                }
            }

            //id preseleccionado
            if (typeof params.id !== 'undefined' && params.id.length) {
                if (indice) {
                    //busca el prerrequisito en la lista de la materia
                    for (let key in this.items[indice].prerrequisitos) {
                        let prerrequisito = this.items[indice].prerrequisitos[key];

                        //si se encuentra, se modifica
                        if (prerrequisito.id === params.id) {
                            $.extend(this.items[indice].prerrequisitos[key], {
                                tipo: params.tipo,
                                valor: params.valor,
                                opcional: params.opcional
                            });

                            //actualiza los cambios
                            this.mostrar();
                        }
                    }
                }
            }
            else {
                let item = {
                    id: new Date().getTime().toString(16), //id único temporal
                    tipo: params.tipo,
                    valor: params.valor,
                    opcional: params.opcional
                };

                if (indice) {
                    this.items[indice].prerrequisitos.push(item);
                }
                else {
                    this.items.push({
                        id: id_materia,
                        prerrequisitos: [item]
                    });
                }

                //actualiza los cambios
                this.mostrar();
            }
        }


        /**
         * Quita un prerrequisito de la variable this.items
         */
        eliminar(id) {
            //materias
            for (let key_materia in this.items) {

                //prerrequisitos
                for (let key_prerrequisito in this.items[key_materia].prerrequisitos) {
                    let prerrequisito = this.items[key_materia].prerrequisitos[key_prerrequisito];

                    //si se encuentra, se modifica
                    if (prerrequisito.id === id) {
                        console.log('deleting', this.items[key_materia].prerrequisitos[key_prerrequisito]);
                        this.items[key_materia].prerrequisitos.splice(key_prerrequisito, 1);

                        this.mostrar();
                        return;
                    }
                }
            }
        }


        /**
         * Carga los prerrequisitos desde la variable this.items
         */
        mostrar() {
            const $contenedor = this.contenedor;

            //quita cualquiera elemento que ya esté cargado
            $contenedor.find('li.prerrequisito').remove();

            //por cada materia
            for (let key_materia in this.items) {
                let $materia = $contenedor.find('li[data-tipo=materia][data-id=' + this.items[key_materia].id + ']');

                //por cada prerrequisito de la materia
                for (let prerrequisito of this.items[key_materia].prerrequisitos) {
                    let html = this.elementoHtml(prerrequisito, this.items[key_materia].id);
                    $materia.after($(html));
                }
            }

            //ata las acciones

            if (!$contenedor.closest('.modal').hasClass('finalizado')) {

                //cuando se hace clic se carga en el formulario para editar
                let fn_cargar_editar = this.procesarCargarEditar.bind(this);
                $contenedor.find('li.prerrequisito').click(function () {
                    fn_cargar_editar($(this));
                });
            }

            //cuando coloca el cursor sobre el requisito de tipo materia se resalta la materia correspondiente
            const fn_resaltar_materia = this.resaltarMateria.bind(this);
            const fn_quitar_resaltes_materia = this.quitarResaltesMateria.bind(this);
            $contenedor.find('li.prerrequisito[data-tipo=1]').each(function (n, el) {
                hoverintent(el,
                    function () {
                        fn_resaltar_materia($(this).data('valor'));
                    }, function () {
                        fn_quitar_resaltes_materia();
                    }
                );
            });
        }


        /**
         * Acción cuando se hace clic en el prerrequisito
         */
        procesarCargarEditar($item) {
            if (!$item.hasClass('editando')) {
                this.cargarEditar($item.data('id_materia'), $item.data('id'));
            }
            else {
                if ($item.data('tipo') === 0) {
                    this.restaurarFormularioUc();
                }
                else {
                    this.restaurarFormularioMateria();
                }
            }
        }


        /**
         * Construye el HTML de un elemento de prerrequisito de una materia
         */
        elementoHtml(opciones, id_materia = '') {
            return '' +
                '<li class="prerrequisito" data-id="' + opciones.id + '" data-id_materia="' + id_materia + '" data-tipo="' + opciones.tipo + '" data-valor="' + opciones.valor + '">' +
                '<span class="tipo-prerrequisito badge badge-secondary">' +
                (opciones.tipo === 0 ? this.texto_uc : this.texto_materia).toUpperCase() +
                '</span> &nbsp;' +
                (opciones.tipo === 0 ? opciones.valor : $('#pre_id_materia').find('option[value=' + opciones.valor + ']').text()) +
                (opciones.opcional ? '*' : '') +
                '</li>';
        }


        /**
         * Carga los datos de un prerrequisito en el formulario para editar
         */
        cargarEditar(id_materia, id) {
            //se busca la materia
            for (let materia of this.items) {
                if (materia.id === id_materia) {

                    //se busca el id en la lista de prerrequisitos de la materia
                    for (let prerrequisito of materia.prerrequisitos) {

                        //si se encuentra, se carga en el formulario correspondiente
                        if (prerrequisito.id === id) {
                            let $frm;
                            if (prerrequisito.tipo === 0) { //tipo uc
                                $frm = this.formulario_uc;
                                $frm.find('input[name=valor]').val(prerrequisito.valor);
                            }
                            else { //tipo materia
                                $frm = this.formulario_materia;
                                $frm.find('select[name=valor]').val(prerrequisito.valor).change();
                            }
                            $frm.find('input[name=id]').val(prerrequisito.id);
                            $frm.find('input[name=opcional]').prop('checked', prerrequisito.opcional);
                            $frm.addClass('editar');
                            PanelLateral.mostrarSeccionQueContiene($frm, true);

                            //agrega la clase 'editando' al prerrequsito para resaltarlo
                            const $contenedor = this.contenedor;
                            const $item = $contenedor.find('li[data-id=' + id + ']');
                            $contenedor.addClass('editando');
                            $contenedor.find('.editando').removeClass('editando');
                            $item.addClass('editando');
                            $item.prevAll('.dd-item').eq(0).addClass('editando');

                            agregarClaseTemp($frm, 'animated pulse');

                            //coloca el foco en el input
                            setTimeout(function() {
                                $frm.find('input[name=valor]').focus();
                            }, 700);

                            break;
                        }
                    }
                    break;
                }
            }
        }


        /**
         * Agrega la clase para resaltar una materia
         */
        resaltarMateria(id) {
            this.contenedor.find('.dd-item[data-tipo=materia][data-id=' + id + ']').addClass('resaltado');
        }


        /**
         * Quita la clase para resaltar materias
         */
        quitarResaltesMateria() {
            this.contenedor.find('.resaltado').removeClass('resaltado');
        }


        /**
         * Agrega la clase 'activo' al prerrequisito cuando se hace clic
         */
        static seleccionarMateria(el) {
            let $item = $(el);
            if ($item.attr('data-nivel') === '2') {
                if ($item.hasClass('activo')) {
                    $item.removeClass('activo');
                }
                else {
                    $item.closest('.nestable').find('.dd-item').removeClass('activo');
                    $item.addClass('activo');
                }
            }
            Prerrequisitos.restaurarListaEnContenedor($item.closest('.editando'));
            if (typeof this !== 'undefined' && typeof this.instancia !== 'undefined') {
                if (typeof this.instancia.restaurarFormularioUc === 'function') {
                    this.instancia.restaurarFormularioUc();
                    this.instancia.restaurarFormularioMateria();
                }
            }
        }


        /**
         * Retorna un arreglo con los prerequisitos de la materia
         */
        listaDeMateria(id_materia, materias, lbl_uc = '') {
            let lista = [];

            for (let item of this.items) {
                if (item.id == id_materia) {

                    for (let prerrequisito of item.prerrequisitos) {
                        //uc
                        if (prerrequisito.tipo === 0) {
                            lista.push(prerrequisito.valor + (lbl_uc.length ? (' ' + lbl_uc) : ''));
                        }
                        //materia
                        else {
                            if (typeof materias === 'object') {
                                for (let materia of materias) {
                                    if (prerrequisito.valor == materia.id) {
                                        lista.push(materia.nombre);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            }

            return lista;
        }


        /**
         * Carga los items a partir de la data
         */
        setJson(val) {
            if (typeof val === 'string') {
                const items = window.JSON.parse(val);
                if (typeof items === 'object' && items !== null) {
                    this.items = items;
                }
            }
            else if (typeof val === 'object' && val !== null) {
                this.items = val;
            }
        }


        /**
         * Retorna el Json en forma de texto
         */
        getJsonString() {
            return window.JSON.stringify( this.items );
        }

    }


    /**
     * Inicialización
     */
    $(document).ready(function() {
        accionesClic();

        inicializarPanelesLaterales();
        inicializarListaAnidadaEstructura();
        inicializarListaAnidadaPrerrequisitos();
        inicializarPrerrequisitos();
    });

</script>
@endsection