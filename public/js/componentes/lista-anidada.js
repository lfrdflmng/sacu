/**
 * Maneja las listas anidadas. (nestable.js)
 */
class ListaAnidada {

    constructor(propiedades) {
        //objecto del plugin nestable
        this.instancia = null;

        //defecto
        this.contenedor = '';
        this.eventoAlCambiar = function(){};
        this.niveles = [];
        this.textos = [];
        this.grupo = 1;
        this.anidar = true;
        this.permitirDragDrop = true;
        this.seleccionable = false;
        this.eventoAlSeleccionar = null;

        if (typeof propiedades === 'object') {
            //contenedor
            switch (typeof propiedades['contenedor']) {
                case 'string':
                    this.contenedor = $('#' + propiedades['contenedor']);
                    break;

                case 'object':
                    this.contenedor = propiedades['contenedor'];
            }

            //eventoAlCambiar
            if (typeof propiedades['eventoAlCambiar'] === 'function') {
                this.eventoAlCambiar = propiedades['eventoAlCambiar'];
            }

            //niveles
            if (typeof propiedades['niveles'] !== 'undefined') {
                this.niveles = propiedades['niveles'];
            }

            //textos
            if (typeof propiedades['textos'] !== 'undefined') {
                this.textos = propiedades['textos'];
            }

            //grupo
            if (typeof propiedades['grupo'] !== 'undefined') {
                this.grupo = propiedades['grupo'];
            }

            //anidar
            if (typeof propiedades['anidar'] === 'boolean') {
                this.anidar = propiedades['anidar'];
            }

            //permitir Drag & Drop
            if (typeof propiedades['permitirDragDrop'] === 'boolean') {
                this.permitirDragDrop = propiedades['permitirDragDrop'];
            }

            //seleccionable
            if (typeof propiedades['seleccionable'] === 'boolean') {
                this.seleccionable = propiedades['seleccionable'];
            }

            //evento al seleccionar
            if (typeof propiedades['eventoAlSeleccionar'] === 'function') {
                this.eventoAlSeleccionar = propiedades['eventoAlSeleccionar'];
            }
        }
    }


    /**
     * Crea el html de la lista anidada según la data
     *
     * @param data
     * @param $destino
     */
    construir(data, $destino) {
        let finalizado = typeof data === 'object' && typeof data['finalizado'] !== 'undefined' && data['finalizado'];
        let fn_cambiar = this.eventoAlCambiar;
        let fn_seleccionar = this.eventoAlSeleccionar;
        let html;
        let estructura;

        this.instancia = this.contenedor.nestable({
            group: this.grupo,
            expandBtnHTML: '<button type="button" class="btn btn-default" data-action="expand"><i class="fa fa-plus"></i></button>',
            collapseBtnHTML: '<button type="button" class="btn btn-default" data-action="collapse"><i class="fa fa-minus"></i></button>',
            onchange: function (el) {
                fn_cambiar(el);
            },
            allowDragDrop: this.permitirDragDrop && !finalizado
        });

        if (typeof data === 'string' && data.length) {
            estructura = window.JSON.parse(data);
        }
        else {
            estructura = data;
        }

        if (typeof estructura === 'object' && !$.isEmptyObject(estructura)) {
            html = '<ol class="dd-list">';

            for (let nivel0 in estructura) {
                if (estructura.hasOwnProperty(nivel0)) {
                    html += this.elementoEstructuraHtml({
                        item: estructura[nivel0],
                        texto: typeof this.textos[0] !== 'undefined' && typeof this.textos[0][estructura[nivel0].id] !== 'undefined' ? this.textos[0][estructura[nivel0].id] : estructura[nivel0].texto,
                        nombre: this.niveles[0],
                        nivel: 0,
                        fijo: false,
                        hijos: this.anidar,
                        seleccionable: this.seleccionable
                    });
                }
            }

            html += '</ol>';
        }
        else {
            html = '<li class="dd-empty"></li>';
        }

        if (typeof $destino !== 'undefined') {
            $destino.html(html);
        }
        else {
            this.contenedor.html(html);
        }

        this.eventoAlCambiar();

        //ata el evento clic si se define la función
        if (typeof fn_seleccionar === 'function') {
            this.contenedor.find('.dd-item').click(function() {
                fn_seleccionar(this);
            });
        }
    }


    /**
     * Construye el HTML de un elemento del filtro y sus hijos
     *
     * @param opciones
     * @returns {string}
     */
    elementoEstructuraHtml(opciones) {
        let item = opciones.item;
        let texto = typeof opciones.texto !== 'undefined' ? opciones.texto : '';
        let nombre = typeof opciones.nombre !== 'undefined' ? opciones.nombre : '';
        let nivel = typeof opciones.nivel === 'number' ? opciones.nivel : 0;
        let fijo = opciones.fijo;
        let botones = typeof opciones.botones === 'boolean' ? opciones.botones : true;
        let hijos = typeof opciones.hijos === 'boolean' ? opciones.hijos : true;
        let seleccionable = typeof opciones.seleccionable === 'boolean' ? opciones.seleccionable : false;
        let html, subitem, tiene_hijos;

        tiene_hijos = nivel < 3 && typeof item.children === 'object';

        html = ListaAnidada.elementoHtml(item.id, texto, nivel, nombre, fijo, false, botones && tiene_hijos, seleccionable);

        if (tiene_hijos) {
            nivel++;

            if (typeof this.niveles[nivel] === 'object') {
                nombre = this.niveles[nivel].nombre;
                fijo = typeof this.niveles[nivel].fijo !== 'undefined' ? this.niveles[nivel].fijo : false;
            }
            else {
                nombre = this.niveles[nivel];
                fijo = false;
            }

            if (hijos) {
                html += '<ol class="dd-list">';
            }
            for (subitem in item.children) {
                if (item.children.hasOwnProperty(subitem)) {
                    if (typeof this.textos === 'object' &&
                        typeof this.textos[nivel] === 'object' &&
                        typeof this.textos[nivel][item.children[subitem].id] !== 'undefined') {
                        texto = this.textos[nivel][item.children[subitem].id];
                    }
                    else {
                        texto = item.children[subitem].texto;
                    }
                    html += this.elementoEstructuraHtml({
                        item: item.children[subitem],
                        texto: texto,
                        nombre: nombre,
                        nivel: nivel,
                        fijo: fijo,
                        botones: botones,
                        seleccionable: seleccionable,
                        hijos: hijos
                    });
                }
            }
            if (hijos) {
                html += '</ol>';
            }
        }

        html += '</li>';
        return html;
    }


    /**
     * Construye el HTML de un elemento del filtro
     */
    static elementoHtml(id, texto, nivel, tipo, fijo, cerrar, botones, seleccionable) {
        fijo = typeof fijo === 'undefined' ? '0' : (fijo ? '1' : '0');
        cerrar = typeof cerrar !== 'boolean' ? true : cerrar;
        seleccionable = typeof seleccionable === 'undefined' ? '0' : (seleccionable ? '1' : '0');
        if (typeof botones === 'undefined') botones = false;
        let html = '<li class="dd-item" data-id="' + id + '" data-tipo="' + tipo + '" data-nivel="' + nivel + '" data-fijo="' + fijo + '" data-seleccionable="' + seleccionable + '">';
        if (botones) {
            html += '<button type="button" class="btn btn-default" data-action="collapse"><i class="fa fa-minus"></i></button>';
            html += '<button type="button" class="btn btn-default" data-action="expand" style="display:none"><i class="fa fa-plus"></i></button>';
        }
        html += '<div class="dd-handle">' + texto + '</div>';
        html += (cerrar ? '</li>' : '');
        return html;
    };


    /**
     * Almacena el objeto con los textos asociados a los ids que se usan en un nivel específico
     *
     * @param nivel
     * @param textos
     */
    establecerTextosNivel(nivel, textos) {
        this.textos[nivel] = textos;
    }


    /**
     * Almacena el objeto con los textos asociados a los ids que se usan en los niveles
     *
     * @param textos
     */
    establecerTextos(textos) {
        this.textos = textos;
    }


    /**
     * Inicializa el plugin nestable que permite el drag & drop
     *
     * @param $contenedor
     * @param opciones
     */
    static inicializarDragDrop($contenedor, opciones) {
        $contenedor.nestable({
            group: typeof opciones['grupo'] !== 'undefined' ? opciones['grupo'] : 1,
            maxDepth: typeof opciones['profundidad'] !== 'undefined' ? opciones['profundidad'] : 1,
            onchange: typeof opciones['eventoAlCambiar'] === 'function' ? opciones['eventoAlCambiar'] : function(){},
            allowDragDrop: typeof opciones['permitirDragDrop'] === 'boolean' ? opciones['permitirDragDrop'] : true
        });
    }


    /**
     * Retorna el Json en forma de texto
     *
     * @param opciones
     * @returns {string}
     */
    getJsonString(opciones) {
        if (this.instancia !== null) {
            let incluir_ids = !(typeof opciones === 'object' && typeof opciones['incluir_ids'] !== 'undefined' && !opciones['incluir_ids']);
            return this.instancia.nestable('serialize', incluir_ids);
        }
        return '';
    }

}