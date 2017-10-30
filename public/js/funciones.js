//Funciones generales

/**
 * Agrega una clase CSS al elemento y se la quita después de cierto tiempo
 *
 * @param $obj
 * @param clases
 * @param duracion
 */
function agregarClaseTemp($obj, clases, duracion) {
    if (typeof duracion === 'undefined') duracion = 3000; //3s
    $obj.addClass(clases);
    setTimeout(function() {
        $obj.removeClass(clases);
    }, duracion);
}


/**
 * Agrega o quita una clase CSS al elemento dependiendo de si 'condicion' es verdadera o no
 *
 * @param $obj
 * @param clases
 * @param condicion
 */
function agregarClaseSoloSi($obj, clases, condicion) {
    if (typeof $obj !== 'object' || !$obj.length) return;
    if (typeof condicion === 'undefined') condicion = false;
    if (condicion) {
        $obj.addClass(clases);
    }
    else {
        $obj.removeClass(clases);
    }
}


/**
 * Envía el formulario via AJAX
 *
 * @param $frm
 * @param fn_listo
 * @param fn_error
 * @param metodo
 * @param extra_data
 * @param url_alt
 * @param fn_completado
 */
function enviarFormulario($frm, fn_listo, fn_error, metodo, extra_data, url_alt, fn_completado) {
    //verifica si está especificada la función a ejecutar antes de llamar el Ajax
    let frm_fn_antes_de_enviar = $frm.attr('data-fn_pre_enviar');
    if (typeof frm_fn_antes_de_enviar === 'string' && frm_fn_antes_de_enviar.length) {
        //si la función retorna falso, se cancela el proceso de enviar el formulario
        if (typeof window[frm_fn_antes_de_enviar] === 'function') {
            if (!window[frm_fn_antes_de_enviar]($frm)) {
                return;
            }
        }
    }
    let frm_method = $frm.attr('method');
    metodo = typeof metodo !== 'string' ? (typeof frm_method !== 'undefined' ? frm_method : 'POST') : metodo;
    extra_data = typeof extra_data !== 'string' ? '' : extra_data;
    let url = typeof url_alt !== 'string' ? $frm.attr('action') : url_alt;
    let con_archivo = $frm.hasClass('con-archivo');
    let form_data;
    if (con_archivo) {
        form_data = new FormData($frm[0]);
    }
    else {
        form_data = $frm.serialize() + extra_data;
    }

    let $holder = $frm.closest('.modal-dialog');
    if ($holder.length) {
        $holder.addClass('procesando');
    }
    else {
        $frm.addClass('procesando');
    }

    $frm.find('.con-error').removeClass('con-error');

    $.ajax({
        type: metodo,
        url: url,
        dataType: 'json',
        data: form_data,//$frm.serialize() + extra_data // serializes the form's elements.
        processData: !con_archivo,
        contentType: !con_archivo ? 'application/x-www-form-urlencoded; charset=UTF-8' : false
    }).done(function(data) {
        if (typeof fn_listo === 'function') {
            fn_listo(data, $frm);
        }
        else {
            let frm_fn_despues_de_enviar = $frm.attr('data-fn_pos_enviar');
            if (typeof frm_fn_despues_de_enviar === 'string' && frm_fn_despues_de_enviar.length) {
                if (typeof window[frm_fn_despues_de_enviar] === 'function') {
                    window[frm_fn_despues_de_enviar](data, $frm);
                }
            }
            else if (typeof window['listoEnviarFormulario'] === 'function') {
                window['listoEnviarFormulario'](data, $frm);
            }
        }
    }).fail(function(data) {
        if (typeof fn_error === 'function') {
            fn_error(data, $frm);
        }
        else {
            if (typeof data['status'] !== 'undefined' && data['status'] === 401) {
                alert('La sesión ha expirado. Por favor inicie sesión.');
                window.location = window.location; //redirecciona
            }
            else {
                alert('Error de conexión.');
            }
        }
    }).always(function() {
        $frm.removeClass('procesando').closest('.modal-dialog').removeClass('procesando');
        if (typeof fn_completado === 'function') {
            fn_completado($frm);
        }
    });
}


/**
 * Borra los valores del input File de tipo Dropify
 *
 * @param $dfs
 */
function resetearDropify($dfs) {
    if (typeof $dfs === 'undefined') {
        $dfs = $('.dropify-wrapper');
    }
    $dfs.removeClass('has-preview has-error');
    let $p = $dfs.find('.dropify-preview');
    $p.hide();
    $p.find('img').remove();
    $dfs.find('input.input-imagen-modificado').val('0');
}


/**
 * Borra los valores de los campos en el formulario excepto los campos con la clase 'static-value'
 *
 * @param $frm
 */
function limpiarFormulario($frm) {
    $frm.find('input[type=text]').not('.static-value').val('');
    $frm.find('input[type=email]').not('.static-value').val('');
    $frm.find('input[type=password]').not('.static-value').val('');
    $frm.find('input[type=tel]').not('.static-value').val('');
    $frm.find('input[type=number]').not('.static-value').val('0');
    $frm.find('input[type=url]').not('.static-value').val('');
    $frm.find('input[type=file]').val('');
    $frm.find('input[type=hidden]').not('.static-value').not('input[name=_token]').not('input[name=_accion]').not('input[name=_fuente]').val('');
    $frm.find('textarea').val('');
    $frm.find('input[type=checkbox]').prop('checked', false); //TODO: consider adding a 'reset-to' data attribute to the html input and use it here
    $frm.find('select option').removeAttr('selected');
    if (typeof jQuery().select2 !== 'undefined') {
        $frm.find('select').val('').trigger('change');
        $frm.find('input[type=hidden].select2ajax').select2('val', '');
        $frm.find('input[type=hidden].select2tags').select2('val', '');
    }
    resetearDropify($frm.find('.dropify-wrapper'));
    if (typeof window['despuesDeLimpiarFormulario'] === 'function') {
        window['despuesDeLimpiarFormulario']($frm);
    }
}


/**
 * Carga un objecto JSON en los campos de un formulario según los nombres y tipos
 *
 * @param $frm
 * @param data
 */
function llenarFormulario($frm, data) {
    let o;
    let attr_type;
    $.each(data, function(key, value) {
        if (key !== 'ok') {
            o = $frm.find('[name=' + key + ']');
            if (!o.length) {
                o = $frm.find('select[name="' + key + '[]"]');
            }
            if (o.length) {
                switch (o.prop('tagName')) {
                    case 'INPUT':
                        attr_type = o.attr('type');
                        if (attr_type === 'text') {
                            if (o.hasClass('input-fecha')) {
                                o.val(convertirFormatoFecha(value, o.attr('data-inputmask-inputformat')));
                            }
                            else {
                                o.val(value);
                            }
                            //o.attr('placeholder', value); to consider
                        }
                        else if (attr_type === 'checkbox') {
                            if (o.hasClass('switch') && typeof $.fn.bootstrapSwitch === 'function') {
                                o.bootstrapSwitch('state', value == 1, true);
                            }
                            o.prop('checked', value == 1);
                        }
                        else if (attr_type === 'hidden') {
                            if (o.hasClass('select2tags')) {
                                if (typeof jQuery().select2 !== 'function') {
                                    o.select2('val', value.split(','));
                                }
                            }
                            else if (o.hasClass('input-imagen')) {
                                //asume el uso de Dropify
                                let tiene_imagen = typeof value === 'string' && value.length;
                                let $contenedor = o.siblings('.dropify-wrapper').eq(0);
                                let $contenedor_previo = $contenedor.find('.dropify-preview');
                                let $contenedor_img = $contenedor_previo.find('.dropify-render');
                                let img;
                                $contenedor.removeClass('has-error');
                                agregarClaseSoloSi($contenedor, 'has-preview', tiene_imagen);
                                if (tiene_imagen) {
                                    if (typeof window['url_imagen'] === 'string') {
                                        img = '<img src="' + window['url_imagen'] + '/' + value + '" alt="">';
                                    }
                                    else {
                                        img = '<img src="' + value + '" alt="">';
                                    }
                                }
                                else {
                                    img = '';
                                }
                                $contenedor_img.html(img);
                                if (tiene_imagen) {
                                    $contenedor_previo.show();
                                }
                                else {
                                    $contenedor_previo.hide();
                                }
                                $('input[name=' + key + '_upload_modificado]').val('0');
                                o.val( value );
                            }
                            else {
                                o.val( value );
                            }
                        }
                        else if (attr_type === 'file') {

                        }
                        else {
                            o.val( value );
                        }
                        break;

                    case 'SELECT':
                        if (o.hasClass('select2ajax')) {
                            if (typeof jQuery().select2 === 'function') {
                                if (o.prop('multiple')) {
                                    //para un select2 de tipo ajax con selección multiple
                                    if (typeof value === 'object') {
                                        o.find('option').remove();
                                        for (let key2 in value) {
                                            if (value.hasOwnProperty(key2)) {
                                                if (typeof value[key2] === 'string' && value[key2].length) {
                                                    //o.append(new Option(value[key2], key2, true)); //<-- no funciona porque colaca selected="" en lugar de selected="selected"
                                                    o.append('<option value="' + key2 + '" selected="selected">' + value[key2] + '</option>');
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        o.val('');
                                    }
                                }
                                else {
                                    //para un select2 de tipo ajax debe existir un _lbl para ese campo. Ejm.: 'usuario_id' debe tener 'usuario_id_lbl' como texto
                                    if (typeof data[key + '_lbl'] === 'undefined' || data[key + '_lbl'] === '') {
                                        o.val('');
                                    }
                                    else {
                                        o.find('option').remove();
                                        o.append(new Option(data[key + '_lbl'], value));
                                    }
                                }
                                o.trigger('change');
                            }
                        }
                        else {
                            let sels;
                            if (typeof value === 'object' && value !== null) {
                                sels = [];
                                $.each(value, function(k, v) {
                                    sels.push(v);
                                });
                            }
                            else {
                                sels = value;
                            }

                            if (typeof jQuery().select2 === 'function' && sels !== null) {
                                o.val(sels).trigger('change');
                            }
                        }
                        break;

                    default:
                        o.val( value );
                }
            }
        }
    });
}


/**
 * Convierte el texto en Tipo Título y remueve espacios duplicados
 *
 * @param str
 * @returns {string}
 */
function tipoTitulo(str) {
    return str.replace(/\s\s+/g, ' ').split(' ').map(function(val){
        return val.charAt(0).toUpperCase() + val.substr(1).toLowerCase();
    }).join(' ');
}


/**
 * Convierte el formato de fecha de Y-m-d a d/m/Y
 *
 * @param fecha_str
 * @param formato
 */
function convertirFormatoFecha(fecha_str, formato) {
    if (typeof formato === 'undefined') formato = 'DD/MM/Y';
    if (typeof moment === 'function') {
        return moment(fecha_str).format(formato);
    }
    let partes = fecha_str.split('-');
    if (partes.length === 3) {
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }
    return fecha_str;
}


/**
 * Retorna o actualiza una barra de progreso
 *
 * @param porcentaje
 * @param $barra
 * @param opciones
 */
function barraProgreso(porcentaje, $barra, opciones) {
    if (typeof porcentaje !== 'number') {
        porcentaje = 100;
    }
    else {
        if (porcentaje < 0) porcentaje = 0;
        if (porcentaje > 100) porcentaje = 100;
    }

    let id_attr = '';
    let clases = '';
    if (typeof opciones === 'object') {
        if (typeof opciones['clases'] === 'string') {
            clases = ' ' + opciones['clases'];
        }

        if (typeof opciones['id'] === 'string') {
            id_attr = ' id="' + opciones[id] + '"';
        }
    }

    if (typeof $barra !== 'object') {
        return '<div' + id_attr + ' class="progress">' +
                '<div class="progress-bar progress-bar-striped progress-bar-animated' + clases + '" role="progressbar" aria-valuenow="' + porcentaje + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + porcentaje + '%"></div>' +
            '</div>';
    }
    else {
        $barra.find('.progress-bar').css('width', porcentaje + '%');
    }
    return '';
}


/**
 * Guarda un valor en el Storage del navegador para ser leído posteriormente
 *
 * @param nombre
 * @param valor
 */
function guardarEnSesion(nombre, valor) {
    if (typeof(Storage) !== 'undefined') {
        localStorage.setItem(nombre, valor);
    }
}


/**
 * Lee un valor desde el Storage del navegador
 *
 * @param nombre
 */
function traerDesdeSesion(nombre) {
    if (typeof(Storage) !== 'undefined') {
        return localStorage.getItem(nombre);
    }
    return null;
}


/**
 * Retorna el texto equivalente en minúsculas y sin tildes
 *
 * @param str
 * @returns {string}
 */
function sinAcentos(str) {
    let r = str.toLowerCase();
    r = r.replace(new RegExp("\\s", 'g'),"");
    r = r.replace(new RegExp("[àáâãäå]", 'g'),"a");
    r = r.replace(new RegExp("æ", 'g'),"ae");
    r = r.replace(new RegExp("ç", 'g'),"c");
    r = r.replace(new RegExp("[èéêë]", 'g'),"e");
    r = r.replace(new RegExp("[ìíîï]", 'g'),"i");
    r = r.replace(new RegExp("ñ", 'g'),"n");
    r = r.replace(new RegExp("[òóôõö]", 'g'),"o");
    r = r.replace(new RegExp("œ", 'g'),"oe");
    r = r.replace(new RegExp("[ùúûü]", 'g'),"u");
    r = r.replace(new RegExp("[ýÿ]", 'g'),"y");
    r = r.replace(new RegExp("\\W", 'g'),"");
    return r;
}


/**
 * Agrega la clase 'hidden' a elementos que no tengan coincidencias con el valor de texto
 *
 * @param texto
 * @param $elementos
 */
function filtrar(texto, $elementos) {
    if (!texto.length) {
        $elementos.removeClass('hidden');
        return;
    }
    let $i;
    texto = sinAcentos(texto);
    $.each($elementos, function(n, i) {
        $i = $(i);
        agregarClaseSoloSi($i, 'hidden', sinAcentos($i.text()).indexOf(texto) === -1);
    });
}


/**
 * Evento que se ejecuta cuando se ha dejado de escribir en el campo de texto
 *
 * $('#element').alFinalizarDeEscribir(callback[, timeout=1000])
 */
(function($){
    $.fn.extend({
        alFinalizarDeEscribir: function(callback, timeout) {
            timeout = timeout || 1e3; // 1s
            let timeoutReference,
                alFinalizarDeEscribir = function(el) {
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el) {
                let $el = $(el);
                $el.is(':input') && $el.on('keyup keypress paste',function(e) {
                    if (e.type == 'keyup' && e.keyCode != 8) return;
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function() {
                        alFinalizarDeEscribir(el);
                    }, timeout);
                }).on('blur',function() {
                    alFinalizarDeEscribir(el);
                });
            });
        }
    });
})(jQuery);