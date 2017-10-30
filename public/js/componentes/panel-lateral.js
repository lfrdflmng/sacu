/**
 * Clase para manejar las acciones básicas del panel lateral
 */
class PanelLateral {

    /**
     * Inicialización
     *
     * @param opciones
     */
    constructor(opciones) {
        this.contenedor = null;

        if (typeof opciones === 'object') {
            if (typeof opciones['contenedor'] === 'object') {
                this.contenedor = opciones['contenedor'];
            }
        }

        if (this.contenedor === null) {
            this.contenedor = $('.panel-lateral');
        }

        this.acciones();
    }


    /**
     * Ata los eventos de los botones del panel lateral
     */
    acciones() {
        this.contenedor.on('click', '.panel-lateral-alternar', function() {
            PanelLateral.mostrarOcultarSeccionQueContiene($(this));
        });

        this.contenedor.on('click', '.panel-lateral-seccion-cabecera', function() {
            PanelLateral.mostrarOcultarSeccionQueContiene($(this));
        });

        let fn_colapsar_todo = this.colapsarTodo.bind(this);
        let fn_expandir_todo = this.expandirTodo.bind(this);
        this.contenedor.on('click', '.panel-lateral-accion', function() {
            let $btn = $(this);
            $btn.toggleClass('expandir colapsar');
            if ($btn.hasClass('expandir')) {
                fn_colapsar_todo();
            }
            else {
                fn_expandir_todo();
            }
        });

        //para buscadores
        accionesFiltro(this.contenedor.find('.input-buscador'), '.panel-lateral-contenido', 'li');
    }


    /**
     * Colapsa todas las secciones del panel
     */
    colapsarTodo() {
        let $items = this.contenedor.find('.panel-lateral-contenido');

        $.each($items, function(n,i) {
            $(i).hide()
                .siblings('.panel-lateral-alternar')
                .find('i.fa')
                .removeClass('fa-minus')
                .addClass('fa-plus');
        });
    }


    /**
     * Expande todas las secciones del panel
     */
    expandirTodo() {
        let $items = this.contenedor.find('.panel-lateral-contenido');

        $.each($items, function(n,i) {
            $(i).show()
                .siblings('.panel-lateral-alternar')
                .find('i.fa')
                .removeClass('fa-plus')
                .addClass('fa-minus');
        });
    }


    /**
     * Muestra u oculta la sección del panel lateral que contiene el elemento
     *
     * @param $el
     * @param solo_mostrar
     * @param ocultar_otros
     */
    static mostrarOcultarSeccionQueContiene($el, solo_mostrar, ocultar_otros) {
        if (typeof solo_mostrar !== 'boolean') solo_mostrar = false;
        if (typeof ocultar_otros !== 'boolean') ocultar_otros = false;

        const $seccion = $el.closest('.panel-lateral-seccion');
        const $btn = $seccion.find('.panel-lateral-alternar');
        const $contenido = $seccion.find('.panel-lateral-contenido');

        if (ocultar_otros) {
            const $contenedor = $el.closest('.panel-lateral');
            const $items = $contenedor.find('.panel-lateral-contenido');
            $.each($items, function(m, i) {
                PanelLateral.ocultarSeccionQueContiene($(i));
            });
        }

        if (!$contenido.is(':visible')) {
            $contenido.show();
            $btn.find('i.fa').addClass('fa-minus').removeClass('fa-plus');
        }
        else if (!solo_mostrar) {
            $contenido.hide();
            $btn.find('i.fa').addClass('fa-plus').removeClass('fa-minus');
        }
    }


    /**
     * Oculta la sección del panel lateral que contiene el elemento
     *
     * @param $el
     */
    static ocultarSeccionQueContiene($el) {
        const $seccion = $el.closest('.panel-lateral-seccion');
        const $btn = $seccion.find('.panel-lateral-alternar');
        const $contenido = $seccion.find('.panel-lateral-contenido');

        if ($contenido.is(':visible')) {
            $contenido.hide();
            $btn.find('i.fa').addClass('fa-plus').removeClass('fa-minus');
        }
    }


    /**
     * Muestra la sección del panel lateral que contiene el elemento
     *
     * @param $el
     * @param ocultar_otros
     */
    static mostrarSeccionQueContiene($el, ocultar_otros) {
        const $seccion = $el.closest('.panel-lateral-seccion');
        const $btn = $seccion.find('.panel-lateral-alternar');
        const $contenido = $seccion.find('.panel-lateral-contenido');

        if (typeof ocultar_otros !== 'boolean') ocultar_otros = false;

        if (ocultar_otros) {
            const $contenedor = $el.closest('.panel-lateral');
            const $items = $contenedor.find('.panel-lateral-contenido');
            $.each($items, function(m, i) {
                PanelLateral.ocultarSeccionQueContiene($(i));
            });
        }

        if (!$contenido.is(':visible')) {
            $contenido.show();
            $btn.find('i.fa').addClass('fa-minus').removeClass('fa-plus');
        }
    }

}