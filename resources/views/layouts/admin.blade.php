<!DOCTYPE html>
<html>
<head>
    <title>SACU</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="JAMIT" name="author">
    <meta content="Sistema Administrativo para el Control Universitario" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="{!! URL::asset('img/favicon/favicon.png') !!}" rel="shortcut icon">
    <link href="{!! URL::asset('img/favicon/apple-touch-icon.png') !!}" rel="apple-touch-icon">
    <link href="{!! URL::asset('css/font-awesome.min.css') !!}" rel="stylesheet">
    {{-- Noty permite mostrar mensajes y notificaciones --}}
    {{-- https://ned.im/noty/#/ --}}
    <link href="{!! URL::asset('css/noty.css') !!}" rel="stylesheet">

    {{-- Confirmaciones personalizadas (para evitar usar la del navegador) --}}
    {{-- https://craftpip.github.io/jquery-confirm/ --}}
    <link href="{!! URL::asset('css/jquery.confirm.min.css') !!}" rel="stylesheet">

    {{-- Maneja tablas dinámicas --}}
    {{-- https://datatables.net/ --}}
    <link href="{!! URL::asset('css/datatables.min.css') !!}" rel="stylesheet">

    {{-- Modals personalizados --}}
    {{-- https://mdbootstrap.com/javascript/modals/ --}}
    <link href="{!! URL::asset('css/enhanced-modals.min.css') !!}" rel="stylesheet">

    {{-- Calendario para los campos de fechas --}}
    {{-- https://eonasdan.github.io/bootstrap-datetimepicker/ --}}
    <link href="{!! URL::asset('css/bootstrap-datetimepicker.min.css') !!}" rel="stylesheet">

    {{-- Campos de selección con búsqueda --}}
    {{-- https://select2.org/ --}}
    <link href="{!! URL::asset('css/select2.min.css') !!}" rel="stylesheet">

    {{-- Animate permite especificar clases para realizar animaciones --}}
    {{-- https://daneden.github.io/animate.css/ --}}
    <link href="{!! URL::asset('css/animate.min.css') !!}" rel="stylesheet">

    {{-- Carga el contenido de la sección 'css' desde la vista hija --}}
    @yield ('css')

    {{-- Estilos generales del tema --}}
    <link href="{!! URL::asset('css/main.css') !!}" rel="stylesheet">

    {{-- Librería javascript de jQuery v3.2.1 --}}
    <script src="{!! URL::asset('js/jquery.min.js') !!}"></script>
</head>

<body>
<div class="all-wrapper menu-side">
    <div class="layout-w">
        <!-------------------- START - Menu telefono -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
            <div class="mm-logo-buttons-w">
                <a class="mm-logo" href="{!! URL::route('dashboard') !!}"><img src="{!! URL::asset('img/logo.png') !!}" alt="LOGO"></a>
                <div class="mm-buttons">
                    <div class="content-panel-open">
                        <div class="os-icon os-icon-grid-circles"></div>
                    </div>
                    <div class="mobile-menu-trigger">
                        <div class="os-icon os-icon-hamburger-menu-1"></div>
                    </div>
                </div>
            </div>
            <div class="menu-and-user">
                <!-------------------- START - Lista menu telefono -------------------->
                <!-- TODO -->
                <!--ul class="main-menu">
                    <li class="has-sub-menu">
                        <a href="index.html">
                            <div class="icon-w">
                                <div class="os-icon os-icon-window-content"></div>
                            </div>
                            <span>Dashboard</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="index.html">Dashboard 1</a></li>
                            <li><a href="apps_projects.html">Dashboard 2</a></li>
                            <li><a href="layouts_menu_top_image.html">Dashboard 3</a></li>
                        </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-hierarchy-structure-2"></div>
                            </div><span>Menu Styles</span></a>
                        <ul class="sub-menu">
                            <li><a href="layouts_menu_side.html">Side Menu Light</a></li>
                            <li><a href="layouts_menu_side_dark.html">Side Menu Dark</a></li>
                            <li><a href="apps_pipeline.html">Side &amp; Top Dark <strong class="badge badge-danger">New</strong></a></li>
                            <li><a href="apps_projects.html">Side &amp; Top <strong class="badge badge-danger">New</strong></a></li>
                            <li><a href="layouts_menu_side_compact.html">Compact Side Menu</a></li>
                            <li><a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a></li>
                            <li><a href="layouts_menu_top.html">Top Menu Light</a></li>
                            <li><a href="layouts_menu_top_dark.html">Top Menu Dark</a></li>
                            <li><a href="layouts_menu_top_image.html">Top Menu Image</a></li>
                        </ul>
                    </li>
                </ul-->
                <!-------------------- END - Lista menu telefono -------------------->
            </div>
        </div>
        <!-------------------- END - Menu telefono -------------------->
        <!-------------------- START - Menu -------------------->
        <div class="desktop-menu menu-side-compact-w menu-activated-on-hover color-scheme-dark">
            <div class="logo-w">
                <a class="logo" href="{!! URL::route('dashboard') !!}"><img src="img/logo.png" alt="LOGO"></a>
            </div>
            <div class="menu-and-user">
                <ul class="main-menu">
                    {!! \App\Http\Controllers\MenuController::contruirMenu() !!}
                </ul>
            </div>
        </div>
        <!-------------------- END - Menu -------------------->
        <div class="content-w">
            <div class="top-menu-secondary">
                <ul>
                    <li><span class="badge badge-pill badge-primary">2017-2018</span></li>
                </ul>
                <div class="top-menu-controls">
                    <!-------------------- START - Notificaciones -------------------->
                    <!--div class="messages-notifications os-dropdown-trigger os-dropdown-center"><i class="os-icon os-icon-mail-14"></i>
                        <div class="new-messages-count">12</div>
                        <div class="os-dropdown light message-list">
                            <div class="icon-w"><i class="os-icon os-icon-mail-14"></i></div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="{{ URL::asset('img/avatar1.jpg') }}"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">José Paradiso</h6>
                                            <h6 class="message-title">Título W</h6>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="{{ URL::asset('img/avatar5.jpg') }}"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Alhealis Lunar</h6>
                                            <h6 class="message-title">Título X</h6>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="{{ URL::asset('img/avatar2.jpg') }}"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Jhon Doe</h6>
                                            <h6 class="message-title">Título Y</h6>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="{{ URL::asset('img/avatar4.jpg') }}"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Jane Doe</h6>
                                            <h6 class="message-title">Título Z</h6>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div-->
                    <!-------------------- END - Notificaciones -------------------->
                    <!-------------------- START - Menu del usuario -------------------->
                    <div class="logged-user-w">
                        <div class="logged-user-i">
                            <div class="avatar-w"><img alt="" src="{{ URL::asset('img/avatar0.jpg') }}"></div>
                            <div class="logged-user-menu">
                                <div class="logged-user-avatar-info">
                                    <div class="avatar-w"><img alt="" src="{{ URL::asset('img/avatar0.jpg') }}"></div>
                                    <div class="logged-user-info-w">
                                        <div class="logged-user-name">Alfredo Fleming</div>
                                        <div class="logged-user-role">Administrator</div>
                                    </div>
                                </div>
                                <div class="bg-icon"><i class="os-icon os-icon os-icon-ui-90"></i></div>
                                <ul>
                                    <li><a href="javascript:;"><i class="os-icon os-icon-user-male-circle2"></i><span>Mi cuenta</span></a></li>
                                    <li><a href="{!! URL::route('cerrar_sesion') !!}"><i class="os-icon os-icon-signs-11"></i><span>Cerrar sesión</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-------------------- END - Menu del usuario -------------------->
                </div>
            </div>
            <!-------------------- START - Contenido principal -------------------->
            <div class="content-i">
                @yield ('contenido')
            </div>
            <!-------------------- END - Contenido principal -------------------->
        </div>
    </div>
    <div class="display-type"></div>
</div>

<!-- FORMULARIO DE ACCIONES -->
<form id="frm_post" action="{!! URL::route('post') !!}" method="POST" class="hidden" autocomplete="off">
    <input type="hidden" name="id">
    <input type="hidden" name="_fuente">
    <input type="hidden" name="_accion">
    <input type="hidden" name="valor">
    {!! csrf_field() !!}
</form>
<!-- /FORMULARIO DE ACCIONES -->

<!-- FORMULARIO PARA BUSQUEDA DE DATOS DE UN ITEM -->
<form id="frm_get" action="{!! URL::route('get') !!}" method="GET" class="hidden" autocomplete="off">
    <input type="hidden" name="id">
    <input type="hidden" name="_fuente">
    <input type="hidden" name="tipo">
    {!! csrf_field() !!}
</form>
<!-- /FORMULARIO PARA BUSQUEDA DE DATOS DE UN ITEM -->

<!-- FORMULARIO PARA HACER SOLICITUDES DE DATOS A UNA RUTA ESPECIFICA -->
<form id="frm_solicitud" action="{!! URL::route('get') !!}" method="GET" autocomplete="off">
    <input type="hidden" name="_fuente">
    <input type="hidden" name="_accion">
    <input type="hidden" name="valor">
</form>
<!-- /FORMULARIO PARA HACER SOLICITUDES DE DATOS A UNA RUTA ESPECIFICA -->

<!-- scripts -->
<script src="{!! URL::asset('js/popper.min.js') !!}"></script> <!-- requerido para bootstrap -->
<script src="{!! URL::asset('js/bootstrap.min.js') !!}"></script> <!-- funciones del framework -->
<script src="{!! URL::asset('js/noty.min.js') !!}"></script> <!-- permite mostrar notificaciones -->
<script src="{!! URL::asset('js/jquery.confirm.min.js') !!}"></script> <!-- permite pedir confirmaciones personalizadas -->
<script src="{!! URL::asset('js/datatables.min.js') !!}"></script> <!-- maneja los datos de la tabla -->
<script src="{!! URL::asset('js/moment.min.js') !!}"></script> <!-- funciones para manejar fechas y horas -->
<script src="{!! URL::asset('js/enhanced-modals.min.js') !!}"></script> <!-- permite usar modals personalizados -->
<script src="{!! URL::asset('js/select2.min.js') !!}"></script> <!-- campos de selección con búsqueda -->
@if (App::getLocale() != 'en')
    <script src="{!! URL::asset('js/select2.' . App::getLocale() . '.js') !!}"></script> <!-- textos en español del select2 -->
@endif
<script src="{!! URL::asset('js/bootstrap-datetimepicker.js') !!}"></script> <!-- calendarios para los campos de fechas -->
<script src="{!! URL::asset('js/jquery.inputmask.min.js') !!}"></script> <!-- especifica máscaras en los campos de textos (ej. formatos de fechas) -->
<script src="{!! URL::asset('js/chart.bundle.min.js') !!}"></script> <!-- gráficas -->
<script src="{!! URL::asset('js/funciones.js') !!}"></script> <!-- funciones generales -->
<script src="{!! URL::asset('js/componentes/tabla.js') !!}"></script> <!-- funciones para el control del datatables -->
<script src="{!! URL::asset('js/main.js') !!}"></script> <!-- funciones generales de la applicación -->
<script type="text/javascript">
    //Algunos textos que se usan en main.js
    const lbl_confirmar = '{!! __('global.confirm') !!}';
    const lbl_ok = '{!! __('global.ok') !!}';
    const lbl_cancelar = '{!! __('global.cancel') !!}';
    const lbl_eliminar = '{!! __('global.delete') !!}';
    const lbl_confirmar_eliminar = '{!! __('global.confirm_delete') !!}';
    const lbl_years = '{!! __('global.years') !!}';
    const lbl_masculino = '{{ __('persona.masculino') }}';
    const lbl_femenino = '{{ __('persona.femenino') }}';

    //Rutas generales
    const url_avatar_defecto = '{!! URL::asset('img/avatar-defecto.jpg') !!}';
    const url_imagen = '{!! URL::asset(config('app.uploads_img_dir')) !!}';
    const url_contar_total = '{!! URL::route('total') !!}';
</script>
@yield ('script')
</body>

</html>