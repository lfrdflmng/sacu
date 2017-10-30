/**
 * Maneja el datatables
 */
class Tabla {

    /**
     * Inicialización
     *
     * @param tabla
     * @param propiedades
     */
    constructor(tabla, propiedades) {
        if (typeof tabla === 'string') {
            this.tabla = $('#' + tabla);
        }
        else if (typeof tabla === 'object') {
            this.tabla = tabla;
        }
        else {
            throw Error('No se pudo inicializar la instancia de la tabla. No se ha especificado el id.');
        }

        //el datatable se inicia en el componente tabla.blade.php, aquí solo se lee la instancia
        this.datatable = this.tabla.DataTable();

        //defecto
        this.fuente = null;
        this.formulario = null;

        if (typeof propiedades === 'object') {

            //fuente
            if (typeof propiedades['fuente'] === 'string') {
                this.fuente = propiedades['fuente'];
            }

            //formulario
            if (typeof propiedades['formulario'] !== 'undefined') {
                if (typeof propiedades['formulario'] === 'object') {
                    this.formulario = propiedades['formulario'];
                }
                else {
                    this.formulario = $('#' + propiedades['formulario']);
                }
            }
        }

        //si la fuente no se especifíca en las propiedades, se lee desde el atributo data-fuente
        if (this.fuente === null && typeof this.tabla.data('fuente') !== 'undefined') {
            this.fuente = this.tabla.data('fuente');
        }
        else {
            this.fuente = 'void';
        }


        //si no se especifíca el formulario se trata de usar por defecto el del modal editar
        if (this.formulario === null) {
            this.formulario = $('#modal_editar_registro').find('form').eq(0);
        }


        if (traerDesdeSesion('tipo_tabla') === '1') {
            this.modoTarjetas();
        }

        this.tabla.closest('.tabla-contenedor').show();

        this.atarBarraAcciones();
    }


    /**
     * Actualiza los datos en la tabla por AJAX
     */
    recargar() {
        this.datatable.ajax.reload(null, false);
    }


    /**
     * Realiza una búsqueda con el valor y la tabla especificados
     *
     * @param valor
     */
    buscar(valor) {
        this.tabla.dataTable().fnFilter($.fn.DataTable.ext.type.search.string(valor));
    }


    /**
     * Realiza la búsqueda basada en el campo de búsqueda
     *
     * @param $input
     */
     buscarDesdeInput($input) {
        this.buscar( $input.val() );
    }


    /**
     * Realiza la búsqueda desde un input en la tabla especificada
     *
     * @param $input
     * @param $tabla
     */
    static buscarDesdeInputEnTabla($input, $tabla) {
        if ($tabla.length) {
            $tabla.dataTable().fnFilter($.fn.DataTable.ext.type.search.string($input.val()));
        }
    }


    /**
     * Cambia el modo en que se muestran los datos en el DataTable (tarjetas / lista)
     * agregando la clase modo-tarjeta al contenedor de la tabla.
     * Requiere la definición de modo-tarjeta en CSS
     *
     * @param modo
     */
    modo(modo) {
        const $contenedor = this.tabla.closest('.tabla-contenedor');

        agregarClaseSoloSi($contenedor, 'modo-tarjeta', modo === 'tarjetas');
        agregarClaseSoloSi($('body'), 'modo-tarjeta', modo === 'tarjetas');

        if (modo === 'lista') {
            //reposiciona el fixedHeader (bug)
            setTimeout(this.datatable.draw, 500);
        }

        guardarEnSesion('tipo_tabla', modo === 'tarjetas' ? 1 : 0);
    }


    /**
     * Cambia el modo del Datatable a tarjetas
     */
    modoTarjetas() {
        this.modo('tarjetas');
    }


    /**
     * Cambia el modo del Datatable a lista
     */
    modoLista() {
        this.modo('lista');
    }


    /**
     * Agrega una animación a la fila con el ID especificado.
     * Requiere la librería animate.css
     *
     * @param id
     */
    resaltarRegistro(id) {
        /*this.datatable.rows().every(function(fila_id) {
            let data = this.data();
            if (data[1] == id) {
                agregarClaseTemp($tabla.find('tbody').find('tr').eq(fila_id), 'animated flash');
                return false;
            }
        });*/
    }


    /**
     * Muestra el modal/formulario y carga los datos para editar
     *
     * @param id
     */
    cargarEditar(id) {
        if (parseInt(id)) {
            let $modal, $modal_dialog, $frm;

            $modal = this.formulario.closest('.modal');
            $modal_dialog = $modal.find('.modal-dialog');
            $modal_dialog.addClass('procesando');

            if ($modal.length) $modal.modal('show');

            $frm = this.formulario;

            traerItemData(id, this.fuente, undefined, function(data) {
                llenarFormulario($frm, data);
                $modal_dialog.removeClass('procesando');
            });
        }
    }


    /**
     * Carga el modal editar con los datos del registro seleccionado en el DataTable
     */
    editarSeleccionado() {
        if (this.tabla.length) {
            let id = 0;

            //busca el id del primer registro seleccionado
            this.datatable.rows({selected: true}).every(function(/*fila_id*/) {
                let data = this.data();
                id = data[1];
                return false;
            });

            if (parseInt(id) > 0) {
                this.cargarEditar(id);
            }
        }
    }


    /**
     * Elimina los registros seleccionados en el DataTable
     */
    eliminarSeleccionados() {
        let ids = [];

        const $tabla = this.tabla;

        if ($tabla.length) {
            //busca los ids de los registros seleccionados
            $tabla.DataTable().rows({selected: true}).every(function(/*fila_id*/) {
                let data = this.data();
                ids.push(data[1]);
            });

            if (ids.length) {
                ids = ids.length > 1 ? JSON.stringify(ids) : ids[0];
                const fn_recargar = this.recargar.bind(this);
                enviarPost(ids, this.fuente, 'eliminar', '', function(data) {
                    if (data['ok'] == 1) {
                        if (typeof data['msj'] === 'string') {
                            mostrarMensajeExito(data['msj']);
                            fn_recargar();
                        }
                    }
                    else {
                        if (typeof data['err'] === 'string') {
                            mostrarMensajeError(data['err']);
                        }
                    }
                });
            }
        }
    }


    /**
     * Inicializa los botones de la barra
     */
    atarBarraAcciones() {
        let $barra;
        let $btn_eliminar, $btn_editar, $input_buscar;
        let $btn_modo_carta, $btn_modo_lista;

        if (typeof this.fuente !== 'undefined') {
            $barra = $('.btn-toolbar.fuente-' + this.fuente);
        }
        else {
            $barra = $('.btn-toolbar');
        }

        $input_buscar = $('input.input-buscador-datatables[data-fuente=' + this.fuente + ']');
        $btn_editar = $barra.find('button.btn-editar');
        $btn_eliminar = $barra.find('button.btn-eliminar');
        $btn_modo_carta = $barra.find('button.btn-modo-cartas');
        $btn_modo_lista = $barra.find('button.btn-modo-lista');

        //cuando se hace clic en editar
        const fn_editar_seleccionado = this.editarSeleccionado.bind(this);
        $btn_editar.click(function() {
            fn_editar_seleccionado();
        });

        //cuando se hace clic en eliminar se pide la confimación
        const fn_eliminar_seleccionados = this.eliminarSeleccionados.bind(this);
        $btn_eliminar.click(function() {
            confirmar(lbl_confirmar_eliminar, function() {
                fn_eliminar_seleccionados();
            }, undefined, lbl_eliminar, undefined, 'red');
        });

        //cuando se hace clic en modo cartas
        const fn_modo_tarjetas = this.modoTarjetas.bind(this);
        $btn_modo_carta.click(function() {
            fn_modo_tarjetas();
        });

        //cuando se hace clic en modo lista
        const fn_modo_lista = this.modoLista.bind(this);
        $btn_modo_lista.click(function() {
            fn_modo_lista();
        });

        //cuando se termina de ingresar el texto en el buscador se realiza la búsqueda
        const fn_buscar_desde_input = this.buscarDesdeInput.bind(this);
        $input_buscar.alFinalizarDeEscribir(function() {
            fn_buscar_desde_input($(this));
        }).on('dblclick', function() { //cuando se hace doble clic se limpia el campo
            $(this).val('');
            fn_buscar_desde_input($(this));
        });
    }


    /**
     * Muestra u oculta la barra de acciones (editar, eliminar) de un Datatable según la selección
     */
    actualizarBarraAccionesItem() {
        let $tabla = this.tabla;
        let total_seleccion = $tabla.find('.selected').length;
        let $barra_accion = $('.btn-toolbar.fuente-' + this.fuente).find('.item-acciones');
        let $btn_editar;

        if (total_seleccion > 0) {
            $btn_editar = $barra_accion.find('button[data-accion=editar]');

            //si hay mas de un registro seleccionado, desactivar el botón editar
            agregarClaseSoloSi($btn_editar, 'disabled', total_seleccion > 1);

            //muestra los botones
            $barra_accion.show();
        }
        else {
            //oculta los botones
            $barra_accion.hide();
        }
    }


    /**
     * Retorna el Id del item seleccionado
     *
     * @returns {*}
     */
    idSeleccionado() {
        let id = 0;

        //busca el id del primer registro seleccionado
        this.datatable.rows({selected: true}).every(function(/*fila_id*/) {
            let data = this.data();
            id = data[1];
            return false;
        });

        return id;
    }


    /**
     * Retorna la data del item seleccionado
     */
    itemSeleccionado() {
        let data = [];

        this.datatable.rows({selected: true}).every(function(/*fila_id*/) {
            data = this.data();
            return false;
        });

        return data;
    }


    /**
     * Retorna el tr seleccionado
     *
     * @returns {*}
     */
    filaSeleccionada() {
        return this.tabla.find('.selected').eq(0);
    }


    /**
     * Da un formato a la data dependiendo de la plantilla
     *
     * @param plantilla
     * @param data
     * @returns {*}
     */
    static formatoColumna(plantilla, data) {
        if (typeof data !== 'string' && typeof data !== 'number' && plantilla !== 'avatar') return '';
        switch (plantilla) {
            case 'negritas':
                return '<b>' + data + '</b>';

            case 'negritas_mayusculas':
                return '<b>' + data.toUpperCase() + '</b>';

            case 'mayusculas':
                return data.toUpperCase();

            case 'titulo':
                return tipoTitulo(data);

            case 'fecha':
                return moment(data).format('DD MMM YY'); //'ll'

            case 'fecha_hora':
                return moment(data).format('ddd, DD MMM YY, h:ss a'); //'llll'

            case 'fecha_edad':
                return moment(data).format('DD MMM YY') + ' (' + moment().diff(data, 'years') + (typeof lbl_years === 'string' ? (' ' + lbl_years) : '') + ')';

            case 'etiqueta':
                return '<span class="badge badge-secondary" style="font-size:100%">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';

            case 'etiquetas':
                if (!data.length) return '';
                let etiquetas = data.split('|');
                let total_etiquetas = etiquetas.length;
                let html = '';
                for (let i = 0; i < total_etiquetas; i++) {
                    if (i > 0) html += '&nbsp;';
                    html += '<span class="badge badge-secondary" style="font-size:100%">' + etiquetas[i].charAt(0).toUpperCase() + etiquetas[i].slice(1) + '</span>';
                }
                return html;

            case 'sexo':
                if (typeof lbl_masculino === 'string') {
                    const m = lbl_masculino;
                    const f = lbl_femenino;
                    return data == 1 ? ('<span title="' + m + '">' + m.charAt(0).toUpperCase() + '</span>') : ('<span title="' + f + '">' + f.charAt(0).toUpperCase() + '</span>');
                }
                else {
                    return data == 1 ? '<i class="fa fa-male"></i>' : '<i class="fa fa-female"></i>';
                }

            case 'avatar':
                let url;
                if (typeof data !== 'string' || !data.length) {
                    url = typeof url_avatar_defecto !== 'undefined' ? url_avatar_defecto : '';
                    return '<img class="avatar" src="' + url + '" alt="">';
                }
                url = typeof url_imagen !== 'undefined' ? url_imagen : '';
                return '<img class="avatar" src="' + url + '/s/' + data + '" alt="">';
        }
        return data;
    }

}