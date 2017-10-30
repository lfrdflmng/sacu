<?php
/**
 * $url
 * $titulo
 * $clases
 * $clases_icono
 * $submenu
 */

//calculo la cantidad de elementos para determinar si debo crear varias columnas
$total_hijos = isset($submenu) && is_array($submenu) ? count($submenu) : 0;
$mitad = $total_hijos > 5 ? floor($total_hijos / 2) : 0;
?>
<li class="{{ $clases or '' }}{{ !empty($submenu) ? ' has-sub-menu' : '' }}">
    <a href="{{ $url or 'javascript:;' }}" title="{{ $titulo or '' }}">
        <div class="icon-w"><i class="{{ $clases_icono or '' }}"></i></div>
    </a>
    @if (!empty($submenu))
    <div class="sub-menu-w">
        @if (!empty($titulo))
        <div class="sub-menu-title">{{ $titulo }}</div>
        @endif
        <div class="sub-menu-icon"><i class="{{ $clases_icono or '' }}"></i></div>
        <div class="sub-menu-i">
            <ul class="sub-menu">
                <?php $i = 0 ?>
                @foreach ($submenu as $item)
                    @if ($mitad && $i == $mitad)
                        </ul>
                        <ul class="sub-menu">
                    @endif
                <li><a href="{{ $item['url'] }}">{{ $item['titulo'] }}</a></li>
                <?php $i++ ?>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</li>