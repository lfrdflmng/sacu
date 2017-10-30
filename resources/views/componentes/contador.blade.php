<?php
/**
 * $id 
 * $col: 4
 * $titulo: ''
 * $total: 0
 * $diferencia: ''
 * $clases_icono: ''
*/
    //id
    if (empty($id)) {
        $id = uniqid('cont');
    }    

    //direrencia
    $diferencia = isset($diferencia) ? (gettype($diferencia) == 'object' && get_class($diferencia) == 'Illuminate\Support\HtmlString' ? (int)$diferencia->toHtml() : (int)$diferencia) : false;

    //total
    if (!isset($total)) $total = 0;
?>
<div id="{!! $id !!}" class="col-sm-{!! $col or '3' !!}">
    <div class="element-box el-tablo">
        <div class="label">{!! $titulo or '' !!}</div>
        <div class="value">-</div>
        @if ($diferencia > 0)
            <div class="trending trending-up-basic"><span>+{!! $diferencia !!}</span><i class="os-icon os-icon-arrow-up2"></i></div>
        @elseif ($diferencia < 0)
            <div class="trending trending-down-basic"><span>{!! $diferencia !!}</span><i class="os-icon os-icon-arrow-down"></i></div>
        @endif
        @if (!empty($clases_icono))
        <div class="bg-icon hidden-sm-down">
            <i class="{!! $clases_icono !!}"></i>
        </div>
        @endif
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if (typeof inicializarContador === 'function') {
            @if (!empty($fuente))
                inicializarContador($('#{!! $id !!}'), '{!! (int)$total !!}', '{!! $fuente !!}');
            @else
                inicializarContador($('#{!! $id !!}'), '{!! (int)$total !!}');
            @endif
        }
        else {
            $('#{!! $id !!}').find('.value').text('{!! $total !!}');
        }
    });
</script>