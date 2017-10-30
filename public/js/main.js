'use strict';

// #1. MENU
// #2. DATATABLES
// #3. MODAL
// #4. FORMULARIOS
// #5. GENERAL

$(function () {
  
    // #1. MENU

    //inicializa el boton del menu para movil
    $('.mobile-menu-trigger').on('click', function () {
        $('.menu-mobile .menu-and-user').slideToggle(200, 'swing');
        return false;
    });

    //inicializa el menu para que se active al pasar el cursor
    let menu_timer;
    let $submenus = $('.menu-activated-on-hover ul.main-menu > li.has-sub-menu');
    $submenus.mouseenter(function () {
        let $elem = $(this);
        clearTimeout(menu_timer);
        $elem.closest('ul').addClass('has-active').find('> li').removeClass('active');
        $elem.addClass('active');
    });
    $submenus.mouseleave(function () {
        let $elem = $(this);
        menu_timer = setTimeout(function () {
          $elem.removeClass('active').closest('ul').removeClass('has-active');
        }, 200);
    });

    //inicializa el menu para que se active al hacer clic
    $('.menu-activated-on-click li.has-sub-menu > a').on('click', function (event) {
        let $elem = $(this).closest('li');
        if ($elem.hasClass('active')) {
            $elem.removeClass('active');
        } else {
            $elem.closest('ul').find('li.active').removeClass('active');
            $elem.addClass('active');
        }
        return false;
    });

    //menu superior tipo lista
    $submenus = $('.os-dropdown-trigger');
    $submenus.on('mouseenter', function () {
        $(this).addClass('over');
    });
    $submenus.on('mouseleave', function () {
        $(this).removeClass('over');
    });

    //animación al navegar entre páginas
    window.onbeforeunload = function() {
        //$('body').addClass('bye');
        $('.content-i').animate({opacity:0}, 1000);
    };


    // #2. DATATABLES

    /*if (traerDesdeSesion('tipo_tabla') === '1') {
        establecerModoCarta();
    }

    $('.tabla-contenedor').show();

    atarBarraAcciones();*/

    //permite buscar ignorando acentos
    $.fn.DataTable.ext.type.search.string = function ( data ) {
        return ! data ?
            '' :
            typeof data === 'string' ?
                data
                    .replace( /έ/g, 'ε' )
                    .replace( /[ύϋΰ]/g, 'υ' )
                    .replace( /ό/g, 'ο' )
                    .replace( /ώ/g, 'ω' )
                    .replace( /ά/g, 'α' )
                    .replace( /[ίϊΐ]/g, 'ι' )
                    .replace( /ή/g, 'η' )
                    .replace( /\n/g, ' ' )
                    .replace( /á/ig, 'a' )
                    .replace( /é/ig, 'e' )
                    .replace( /í/ig, 'i' )
                    .replace( /ó/ig, 'o' )
                    .replace( /ú/ig, 'u' )
                    .replace( /ê/ig, 'e' )
                    .replace( /î/ig, 'i' )
                    .replace( /ô/ig, 'o' )
                    .replace( /è/ig, 'e' )
                    .replace( /ï/ig, 'i' )
                    .replace( /ü/ig, 'u' )
                    .replace( /ã/ig, 'a' )
                    .replace( /õ/ig, 'o' )
                    .replace( /ç/ig, 'c' )
                    .replace( /ì/ig, 'i' ) :
                data;
    };

    //cuando se presiona Ctrl + Alt + N, se realiza la acción del botón 'Nuevo'
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyN') {
            let $btn = $('.btn-nuevo');
            if ($btn.length === 1) {
                $btn.click();
            }
        }
    });

    //cuando se presiona Ctrl + Alt + S, se activa el campo de búsqueda
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.altKey && e.code === 'KeyB') {
            let $input = $('.input-buscador-datatables').eq(0);
            if ($input.length) {
                $input.focus().val('');
            }
        }
    });


    // #3. MODAL

    let $modal = $('.modal');

    $modal.on('shown.bs.modal', function() {
        //selecciona el campo con el atributo 'autofocus'
        $(this).find('[autofocus]').eq(0).focus();
    });

    $modal.find('button.btn-ok').click(function() {
        //envía el formulario dentro del modal
        $(this).closest('.modal').find('form').eq(0).submit();
    });

    $modal.find('.modal-title').not('.fijo').click(function() {
        let $dialog = $(this).closest('.modal-dialog');
        $dialog.toggleClass('modal-full-height');
        $dialog.toggleClass('modal-fluid');
    });


    // #4. FORMULARIOS

    let $forms = $('form.ajax-submit');

    //cuando se envia el formulario se cancela y se envia por AJAX
    $forms.submit(function(e) {
        e.preventDefault();
        e.stopPropagation();
        enviarFormulario($(this));
        return false;
    });

    //cuando se está en un campo de texto y se presiona enter se envia el formulario
    $forms.find('input[type=text]').on('keypress', function(e) {
        if (e.which === 13) {
            let $frm = $(this).closest('form');
            if ($frm.length) {
                $frm.submit();
            }
        }
    });

});


// #4. FORMULARIOS

/**
 * Función que se ejecuta por defecto al finalizar el envío del formulario
 *
 * @param data
 * @param $frm
 */
function listoEnviarFormulario(data, $frm) {
    if (typeof data === 'undefined') return;

    //resultado satisfactorio
    if (data['ok'] == 1) {
        if (typeof $frm === 'object' && $frm.length) {
            //cierra el modal
            $frm.closest('.modal').modal('hide');

            //muestra el mensaje
            if (typeof data['msj'] !== 'undefined') {
                mostrarMensajeExito(data['msj']);
            }

            //limpia el formulario
            limpiarFormulario($frm);

            //recarga los datos en la tabla
            if (typeof window['tabla_principal'] === 'object') {
                window['tabla_principal'].recargar();
            }
        }
    }

    //retorna algun error
    else {
        if (typeof data['err'] === 'string') {
            mostrarMensajeError(data['err']);
        }
        if (typeof data['err_campo'] === 'string') {
            let $campo = $frm.closest('.modal').find('*[name=' + data['err_campo'] + ']').closest('.form-group');
            if ($campo.length) {
                $campo.addClass('con-error');
                agregarClaseTemp($campo, 'animated flash');
            }
        }
    }
}


/**
 * Muestra un mensaje de notificación al usuario
 *
 * @param msj
 * @param tipo
 * @param duracion
 * @param clase_entrada
 * @param clase_salida
 */
function mostrarMensaje(msj, tipo, duracion, clase_entrada, clase_salida) {
    if (typeof tipo !== 'string') tipo = 'alert';
    if (typeof duracion === 'undefined') duracion = 3000;
    if (typeof clase_entrada !== 'string') clase_entrada = 'bounceInLeft';
    if (typeof clase_salida !== 'string') clase_salida = 'bounceOutLeft';

    new Noty({
        theme: 'metroui',
        type: tipo,
        layout: 'topLeft',
        text: msj,
        timeout: duracion,
        progressBar: true,
        animation: {
            open: 'animated ' + clase_entrada,
            close: 'animated ' + clase_salida
        }
    }).show();
}


/**
 * Muestra una notificación de éxito
 *
 * @param msj
 */
function mostrarMensajeExito(msj) {
    mostrarMensaje('<i class="fa fa-check"></i> &nbsp;' + msj, 'success');
}


/**
 * Muestra una notificación de error
 *
 * @param msj
 */
function mostrarMensajeError(msj) {
    mostrarMensaje('<i class="fa fa-times"></i> &nbsp;' + msj, 'error', 4000, 'shake', 'fadeOut');
}


/**
 * Pide confirmación al usuario
 * Require el plugin jQuery-Confirm
 *
 * @param contenido
 * @param fn_confirmar
 * @param titulo
 * @param btn_confirmar
 * @param btn_cancelar
 * @param tipo
 * @param fn_cancelar
 */
function confirmar(contenido, fn_confirmar, titulo, btn_confirmar, btn_cancelar, tipo, fn_cancelar) {
    titulo = typeof titulo === 'undefined' ? (typeof lbl_confirmar === 'string' ? lbl_confirmar : '') : titulo;
    btn_confirmar = typeof btn_confirmar === 'undefined' ? (typeof lbl_ok === 'string' ? lbl_ok : '') : btn_confirmar;
    btn_cancelar = typeof btn_cancelar === 'undefined' ? (typeof lbl_cancelar === 'string' ? lbl_cancelar : '') : btn_cancelar;
    $.confirm({
        title: titulo,
        content: contenido,
        type: tipo,
        buttons: {
            confirm: {
                text: btn_confirmar,
                action: fn_confirmar,
                btnClass: typeof tipo === 'string' && tipo === 'red' ? 'btn-danger' : 'btn-primary'
            },
            cancel: {
                text: btn_cancelar,
                action: typeof fn_cancelar === 'function' ? fn_cancelar : function(){}
            }
        },
        confirmButton: btn_confirmar,
        cancelButton: btn_cancelar
    });
}


/**
 * Realiza una petición AJAX para realizar una acción especificada al item o a los items
 * con la ids especificadas. La fuente representa el modelo.
 *
 * @param ids
 * @param fuente
 * @param accion
 * @param valor
 * @param fn_listo
 */
function enviarPost(ids, fuente, accion, valor, fn_listo) {
    let $frm = $('#frm_post');
    $frm.find('input[name=id]').val(ids);
    $frm.find('input[name=_fuente]').val(typeof fuente === 'undefined' ? '' : fuente);
    $frm.find('input[name=_accion]').val(typeof accion === 'undefined' ? '' : accion);
    $frm.find('input[name=valor]').val(typeof valor === 'undefined' ? '' : valor);
    enviarFormulario($frm, fn_listo);
}


/**
 * Realiza una petición AJAX para traer los datos de un item con la id
 * especificada. La fuente representa el modelo.
 *
 * @param id
 * @param fuente
 * @param tipo
 * @param fn_listo
 */
function traerItemData(id, fuente, tipo, fn_listo) {
    let $frm = $('#frm_get');
    $frm.find('input[name=id]').val(id);
    $frm.find('input[name=_fuente]').val(fuente);
    $frm.find('input[name=tipo]').val(typeof tipo === 'undefined' ? '' : tipo);
    enviarFormulario($frm, fn_listo);
}


/**
 * Inicializa el campo fecha.
 * Requiere el plugin Bootstrap Datetimepicker
 *
 * @param $campo
 * @param formato
 * @param lenguaje
 */
function inicializarCampoFecha($campo, formato, lenguaje) {
    if (typeof formato !== 'string') formato = 'DD/MM/YYYY';
    $campo.datetimepicker({
        //inline: true,
        format: formato,
        locale: typeof lenguaje === 'string' ? lenguaje : 'es',
        /*showClear: true,
        showClose: true,*/
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar-o',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-calendar-check-o',
            clear: 'fa fa-trash-o',
            close: 'fa fa-times'
        }/*,
        horizontal: 'left',
        vertical: 'auto'*/
    });
    $campo.inputmask();
}


/**
 * Inicializa el campo de selección.
 * Requiere el plugin Select2
 *
 * @param $campo
 * @param placeholder
 * @param url
 * @param fuente
 * @param fn_formato
 * @param lenguaje
 */
function inicializarCampoSeleccion($campo, placeholder, url, fuente, fn_formato, lenguaje) {
    $campo.select2({
        placeholder: placeholder,
        language: typeof lenguaje === 'string' ? lenguaje : 'es',
        minimumResultsForSearch: typeof url !== 'undefined' && url.length ? 0 : 10,
        minimumInputLength: typeof url !== 'undefined' && url.length ? 1 : 0,
        ajax: typeof url !== 'string' || !url.length ? null : {
            url: url,
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return {
                    busqueda: params.term,
                    _fuente: fuente,
                    campo: $campo.attr('id') || ''
                };
            }
        },
        templateResult: typeof fn_formato === 'function' ? fn_formato : function(state) {
            return state.text;
        }
    });
}


/**
 * Plantilla para el resultado del Select2 con avatar
 *
 * @param state
 * @returns {*}
 */
function formatoSeleccionAvatar(state) {
    if (!state.id) {
        return state.text;
    }
    //state.element.value.toLowerCase()

    if (typeof state.img === 'undefined' || !state.img.length) {
        return state.text;
    }

    let subtext = typeof state.subtext !== 'undefined' && state.subtext.length ? ('<br><span class="small">&nbsp;&nbsp;' + state.subtext + '</span>') : '';
    let img_style = subtext.length ? ' style="display:inline-block;margin-top:-22px"' : '';
    let txt_style = subtext.length ? ' style="display:inline-block"' : '';

    return $(
        '<div><img class="avatar"' + img_style + ' src="' + state.img + '" alt=""> <span' + txt_style + '>&nbsp;&nbsp;<b>' + state.text + '</b>' + subtext + '</span></div>'
    );
}


/**
 * Inicializa el campo para subir imagenes.
 * Requiere el plugin Dropify
 *
 * @param $campo
 */
function inicializarCampoImagen($campo) {
    let $df = $campo.dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove':  '',
            'error':   ''
        },
        error: {
            'fileSize': 'Max.: {{ value }}.',
            'minWidth': 'Min.: {{ value }}px.',
            'maxWidth': 'Max.: {{ value }}px.',
            'minHeight': 'Min.: ({{ value }}}px.',
            'maxHeight': 'Max.: ({{ value }}px.',
            'imageFormat': '({{ value }})'
        },
        tpl: {
            message:         '<div class="dropify-message"><span class="file-icon" /></div>',
            preview:         '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"></div></div></div>',
            clearButton:     '<button type="button" class="dropify-clear"><i class="fa fa-trash"></i></button>'
        }
    });

    $df.on('dropify.afterClear', function(e) {
        let $modificado = $('#' + $(e.target).attr('id') + '_upload_modificado');
        $modificado.val('1');
    });

    $campo.on('change', function(e) {
        let $modificado = $('#' + $(e.target).attr('id') + '_upload_modificado');
        $modificado.val('1');
    });

    $campo.closest('form').addClass('con-archivo');
}


/**
 * Inicializa el componente de selección de pestañas
 *
 * @param $pestana
 */
function inicializarPestanas($pestana) {
    let $tabs = $pestana.find('.nav-item');

    $tabs.click(function(e) {
        let $tab = $(this);
        let destino, $destino, $tabs, fn;

        //pestañas no seleccionadas
        $tabs = $tab.siblings('.nav-item').find('a');
        $tabs.removeClass('active');
        $.each($tabs, function(n,t) {
            destino = $(t).attr('data-destino');
            if (typeof destino === 'string' && destino.length) {
                $('#' + destino).addClass('hidden');
            }
        });

        //pestaña seleccionada
        $tab = $tab.find('a');
        $tab.addClass('active');
        destino = $tab.attr('data-destino');
        if (typeof destino === 'string' && destino.length) {
            $destino = $('#' + destino);
            if ($destino.length) {
                $destino.removeClass('hidden');
                fn = $destino.attr('data-fn');
                if (typeof fn !== 'undefined' && typeof window[fn] === 'function') {
                    window[fn]();
                }
            }
        }

        e.preventDefault();
        e.stopPropagation();
        return false;
    });
}


function seleccionarPestana($li) {
    $li.click();
}


// #5. GENERAL

function accionesFiltro($item, selector_padre, selector_elementos) {
    if (typeof $item === 'undefined') $item = $('.input-buscador');
    $item.on('dblclick', function() {
        let $input = $(this);
        $input.val('');
        if (typeof selector_padre === 'string' && typeof selector_elementos === 'string') {
            filtrar('', $input.closest(selector_padre).find(selector_elementos));
        }
    });

    //TODO: definir un selector_padre y un selector_elementos por defecto
    if (typeof selector_padre === 'string' && typeof selector_elementos === 'string') {
        $item.alFinalizarDeEscribir(function() {
            let $input = $(this);
            filtrar($input.val(), $input.closest(selector_padre).find(selector_elementos));
        });
    }
}


/**
 * Muestra la estuctura en forma de árbol usando SVG
 */
function inicializarVistaArbol(json, id_contenedor) {
    if (typeof id_contenedor === 'undefined') id_contenedor = 'pestana_vista';
    let margin = {top: 20, right: 120, bottom: 20, left: 120},
        width = 900 - margin.right - margin.left,
        height = 650 - margin.top - margin.bottom;

    let i = 0,
        duration = 750,
        root;

    let tree = d3.layout.tree()
        .size([height, width]);

    let diagonal = d3.svg.diagonal()
        .projection(function(d) { return [d.y, d.x]; });

    $('#' + id_contenedor).html('');
    let svg = d3.select('#' + id_contenedor).append('svg')
        .attr('width', width + margin.right + margin.left)
        .attr('height', height + margin.top + margin.bottom)
        .append('g')
        .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

    //d3.json('flare.json', function(error, flare) {
        //if (error) throw error;

        root = json;//flare;
        root.x0 = height / 2;
        root.y0 = 0;

        function collapse(d) {
            if (d.children) {
                d._children = d.children;
                d._children.forEach(collapse);
                d.children = null;
            }
        }

        root.children.forEach(collapse);
        update(root);
    //});

    d3.select(self.frameElement).style('height', '800px');

    function update(source) {
        let nodes = tree.nodes(root).reverse(),
            links = tree.links(nodes);

        nodes.forEach(function(d) { d.y = d.depth * 180; });

        let node = svg.selectAll('g.node')
            .data(nodes, function(d) { return d.id || (d.id = ++i); });

        let nodeEnter = node.enter().append('g')
            .attr('class', 'node')
            .attr('transform', function(d) { return 'translate(' + source.y0 + ',' + source.x0 + ')'; })
            .on('click', click);

        nodeEnter.append('circle')
            .attr('r', 1e-6)
            .style('fill', function(d) { return d._children ? 'lightsteelblue' : '#fff'; });

        nodeEnter.append('text')
            .attr('x', function(d) { return d.children || d._children ? -10 : 10; })
            .attr('dy', '.35em')
            .attr('text-anchor', function(d) { return d.children || d._children ? 'end' : 'start'; })
            .text(function(d) { return d.texto; })//d.id
            .style('fill-opacity', 1e-6);

        let nodeUpdate = node.transition()
            .duration(duration)
            .attr('transform', function(d) { return 'translate(' + d.y + ',' + d.x + ')'; });

        nodeUpdate.select('circle')
            .attr('r', 4.5)
            .style('fill', function(d) { return d._children ? 'lightsteelblue' : '#fff'; });

        nodeUpdate.select('text')
            .style('fill-opacity', 1);

        let nodeExit = node.exit().transition()
            .duration(duration)
            .attr('transform', function(d) { return 'translate(' + source.y + ',' + source.x + ')'; })
            .remove();

        nodeExit.select('circle')
            .attr('r', 1e-6);

        nodeExit.select('text')
            .style('fill-opacity', 1e-6);

        let link = svg.selectAll('path.link')
            .data(links, function(d) { return d.target.id; });

        link.enter().insert('path', 'g')
            .attr('class', 'link')
            .attr('d', function(d) {
                let o = {x: source.x0, y: source.y0};
                return diagonal({source: o, target: o});
            });

        link.transition()
            .duration(duration)
            .attr('d', diagonal);

        link.exit().transition()
            .duration(duration)
            .attr('d', function(d) {
                let o = {x: source.x, y: source.y};
                return diagonal({source: o, target: o});
            })
            .remove();

        nodes.forEach(function(d) {
            d.x0 = d.x;
            d.y0 = d.y;
        });
    }

    function click(d) {
        if (d.children) {
            d._children = d.children;
            d.children = null;
        } else {
            d.children = d._children;
            d._children = null;
        }
        update(d);
    }
}


/**
 * Inicializa el contador (contador.js)
 */
function inicializarContador($el, val, fuente) {
    if (typeof Contador === 'function') {
        new Contador({
            contenedor: $el,
            max: val,
            fuente: typeof fuente !== 'undefined' ? fuente : null
        });
    }
}


/**
 * Inicializa la gráfica de tipo Dona
 *
 * @param $el
 * @param data
 */
function inicializarGraficaDona($el, data) {
    if ($el.length) {
        new Chart($el, {
            type: 'doughnut',
            data: data,
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                animation: {
                    animateScale: false
                },
                cutoutPercentage: 80
            }
        });
    }
}