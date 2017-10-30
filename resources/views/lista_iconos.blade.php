@extends ('layouts.admin')

@section ('css')
    <style type="text/css">
        .lista-iconos i {
            font-size: 50px;
            display: inline-block;
            padding: 20px;
        }
    </style>
@endsection

@section ('contenido')
    <div class="lista-iconos">
        <i class="os-icon os-icon-star-full" title="os-icon os-icon-star-full"></i>
        <i class="os-icon os-icon-arrow-2-right" title="os-icon os-icon-arrow-2-right"></i>
        <i class="os-icon os-icon-minus" title="os-icon os-icon-minus"></i>
        <i class="os-icon os-icon-arrow-right" title="os-icon os-icon-arrow-right"></i>
        <i class="os-icon os-icon-arrow-right2" title="os-icon os-icon-arrow-right2"></i>
        <i class="os-icon os-icon-arrow-right3" title="os-icon os-icon-arrow-right3"></i>
        <i class="os-icon os-icon-arrow-right4" title="os-icon os-icon-arrow-right4"></i>
        <i class="os-icon os-icon-arrow-right5" title="os-icon os-icon-arrow-right5"></i>
        <i class="os-icon os-icon-arrow-left" title="os-icon os-icon-arrow-left"></i>
        <i class="os-icon os-icon-arrow-left2" title="os-icon os-icon-arrow-left2"></i>
        <i class="os-icon os-icon-arrow-left3" title="os-icon os-icon-arrow-left3"></i>
        <i class="os-icon os-icon-arrow-left4" title="os-icon os-icon-arrow-left4"></i>
        <i class="os-icon os-icon-arrow-up" title="os-icon os-icon-arrow-up"></i>
        <i class="os-icon os-icon-arrow-down" title="os-icon os-icon-arrow-down"></i>
        <i class="os-icon os-icon-arrow-left5" title="os-icon os-icon-arrow-left5"></i>
        <i class="os-icon os-icon-arrow-down2" title="os-icon os-icon-arrow-down2"></i>
        <i class="os-icon os-icon-arrow-down3" title="os-icon os-icon-arrow-down3"></i>
        <i class="os-icon os-icon-arrow-down4" title="os-icon os-icon-arrow-down4"></i>
        <i class="os-icon os-icon-arrow-up2" title="os-icon os-icon-arrow-up2"></i>
        <i class="os-icon os-icon-arrow-up3" title="os-icon os-icon-arrow-up3"></i>
        <i class="os-icon os-icon-arrow-down5" title="os-icon os-icon-arrow-down5"></i>
        <i class="os-icon os-icon-arrow-up4" title="os-icon os-icon-arrow-up4"></i>
        <i class="os-icon os-icon-arrow-up5" title="os-icon os-icon-arrow-up5"></i>
        <i class="os-icon os-icon-search" title="os-icon os-icon-search"></i>
        <i class="os-icon os-icon-ui-34" title="os-icon os-icon-ui-34"></i>
        <i class="os-icon os-icon-ui-21" title="os-icon os-icon-ui-21"></i>
        <i class="os-icon os-icon-documents-15" title="os-icon os-icon-documents-15"></i>
        <i class="os-icon os-icon-documents-17" title="os-icon os-icon-documents-17"></i>
        <i class="os-icon os-icon-documents-11" title="os-icon os-icon-documents-11"></i>
        <i class="os-icon os-icon-documents-13" title="os-icon os-icon-documents-13"></i>
        <i class="os-icon os-icon-ui-23" title="os-icon os-icon-ui-23"></i>
        <i class="os-icon os-icon-home-11" title="os-icon os-icon-home-11"></i>
        <i class="os-icon os-icon-ui-09" title="os-icon os-icon-ui-09"></i>
        <i class="os-icon os-icon-old-tv-2" title="os-icon os-icon-old-tv-2"></i>
        <i class="os-icon os-icon-fire" title="os-icon os-icon-fire"></i>
        <i class="os-icon os-icon-home-10" title="os-icon os-icon-home-10"></i>
        <i class="os-icon os-icon-home-09" title="os-icon os-icon-home-09"></i>
        <i class="os-icon os-icon-home-13" title="os-icon os-icon-home-13"></i>
        <i class="os-icon os-icon-home-34" title="os-icon os-icon-home-34"></i>
        <i class="os-icon os-icon-ui-90" title="os-icon os-icon-ui-90"></i>
        <i class="os-icon os-icon-ui-03" title="os-icon os-icon-ui-03"></i>
        <i class="os-icon os-icon-ui-83" title="os-icon os-icon-ui-83"></i>
        <i class="os-icon os-icon-ui-74" title="os-icon os-icon-ui-74"></i>
        <i class="os-icon os-icon-pencil-12" title="os-icon os-icon-pencil-12"></i>
        <i class="os-icon os-icon-ui-33" title="os-icon os-icon-ui-33"></i>
        <i class="os-icon os-icon-ui-49" title="os-icon os-icon-ui-49"></i>
        <i class="os-icon os-icon-grid-10" title="os-icon os-icon-grid-10"></i>
        <i class="os-icon os-icon-common-03" title="os-icon os-icon-common-03"></i>
        <i class="os-icon os-icon-ui-22" title="os-icon os-icon-ui-22"></i>
        <i class="os-icon os-icon-ui-46" title="os-icon os-icon-ui-46"></i>
        <i class="os-icon os-icon-basic-1-138-quotes" title="os-icon os-icon-basic-1-138-quotes"></i>
        <i class="os-icon os-icon-ui-07" title="os-icon os-icon-ui-07"></i>
        <i class="os-icon os-icon-social-09" title="os-icon os-icon-social-09"></i>
        <i class="os-icon os-icon-finance-28" title="os-icon os-icon-finance-28"></i>
        <i class="os-icon os-icon-finance-29" title="os-icon os-icon-finance-29"></i>
        <i class="os-icon os-icon-checkmark" title="os-icon os-icon-checkmark"></i>
        <i class="os-icon os-icon-ui-93" title="os-icon os-icon-ui-93"></i>
        <i class="os-icon os-icon-mail-14" title="os-icon os-icon-mail-14"></i>
        <i class="os-icon os-icon-phone-15" title="os-icon os-icon-phone-15"></i>
        <i class="os-icon os-icon-phone-18" title="os-icon os-icon-phone-18"></i>
        <i class="os-icon os-icon-ui-55" title="os-icon os-icon-ui-55"></i>
        <i class="os-icon os-icon-mail-19" title="os-icon os-icon-mail-19"></i>
        <i class="os-icon os-icon-mail-18" title="os-icon os-icon-mail-18"></i>
        <i class="os-icon os-icon-grid-18" title="os-icon os-icon-grid-18"></i>
        <i class="os-icon os-icon-ui-02" title="os-icon os-icon-ui-02"></i>
        <i class="os-icon os-icon-ui-37" title="os-icon os-icon-ui-37"></i>
        <i class="os-icon os-icon-common-07" title="os-icon os-icon-common-07"></i>
        <i class="os-icon os-icon-ui-54" title="os-icon os-icon-ui-54"></i>
        <i class="os-icon os-icon-ui-44" title="os-icon os-icon-ui-44"></i>
        <i class="os-icon os-icon-ui-15" title="os-icon os-icon-ui-15"></i>
        <i class="os-icon os-icon-documents-03" title="os-icon os-icon-documents-03"></i>
        <i class="os-icon os-icon-ui-92" title="os-icon os-icon-ui-92"></i>
        <i class="os-icon os-icon-phone-21" title="os-icon os-icon-phone-21"></i>
        <i class="os-icon os-icon-documents-07" title="os-icon os-icon-documents-07"></i>
        <i class="os-icon os-icon-others-29" title="os-icon os-icon-others-29"></i>
        <i class="os-icon os-icon-ui-65" title="os-icon os-icon-ui-65"></i>
        <i class="os-icon os-icon-ui-51" title="os-icon os-icon-ui-51"></i>
        <i class="os-icon os-icon-mail-07" title="os-icon os-icon-mail-07"></i>
        <i class="os-icon os-icon-mail-01" title="os-icon os-icon-mail-01"></i>
        <i class="os-icon os-icon-others-43" title="os-icon os-icon-others-43"></i>
        <i class="os-icon os-icon-mail-12" title="os-icon os-icon-mail-12"></i>
        <i class="os-icon os-icon-signs-11" title="os-icon os-icon-signs-11"></i>
        <i class="os-icon os-icon-coins-4" title="os-icon os-icon-coins-4"></i>
        <i class="os-icon os-icon-user-male-circle2" title="os-icon os-icon-user-male-circle2"></i>
        <i class="os-icon os-icon-emoticon-smile" title="os-icon os-icon-emoticon-smile"></i>
        <i class="os-icon os-icon-robot-2" title="os-icon os-icon-robot-2"></i>
        <i class="os-icon os-icon-robot-1" title="os-icon os-icon-robot-1"></i>
        <i class="os-icon os-icon-crown" title="os-icon os-icon-crown"></i>
        <i class="os-icon os-icon-cancel-circle" title="os-icon os-icon-cancel-circle"></i>
        <i class="os-icon os-icon-cancel-square" title="os-icon os-icon-cancel-square"></i>
        <i class="os-icon os-icon-close" title="os-icon os-icon-close"></i>
        <i class="os-icon os-icon-grid-circles" title="os-icon os-icon-grid-circles"></i>
        <i class="os-icon os-icon-grid-squares-22" title="os-icon os-icon-grid-squares-22"></i>
        <i class="os-icon os-icon-grid-squares2" title="os-icon os-icon-grid-squares2"></i>
        <i class="os-icon os-icon-tasks-checked" title="os-icon os-icon-tasks-checked"></i>
        <i class="os-icon os-icon-hierarchy-structure-2" title="os-icon os-icon-hierarchy-structure-2"></i>
        <i class="os-icon os-icon-agenda-1" title="os-icon os-icon-agenda-1"></i>
        <i class="os-icon os-icon-cv-2" title="os-icon os-icon-cv-2"></i>
        <i class="os-icon os-icon-grid-squares-2" title="os-icon os-icon-grid-squares-2"></i>
        <i class="os-icon os-icon-grid-squares" title="os-icon os-icon-grid-squares"></i>
        <i class="os-icon os-icon-calendar-time" title="os-icon os-icon-calendar-time"></i>
        <i class="os-icon os-icon-twitter" title="os-icon os-icon-twitter"></i>
        <i class="os-icon os-icon-facebook" title="os-icon os-icon-facebook"></i>
        <i class="os-icon os-icon-pie-chart-2" title="os-icon os-icon-pie-chart-2"></i>
        <i class="os-icon os-icon-pie-chart-1" title="os-icon os-icon-pie-chart-1"></i>
        <i class="os-icon os-icon-pie-chart-3" title="os-icon os-icon-pie-chart-3"></i>
        <i class="os-icon os-icon-donut-chart-1" title="os-icon os-icon-donut-chart-1"></i>
        <i class="os-icon os-icon-bar-chart-up" title="os-icon os-icon-bar-chart-up"></i>
        <i class="os-icon os-icon-bar-chart-stats-up" title="os-icon os-icon-bar-chart-stats-up"></i>
        <i class="os-icon os-icon-hamburger-menu-2" title="os-icon os-icon-hamburger-menu-2"></i>
        <i class="os-icon os-icon-hamburger-menu-1" title="os-icon os-icon-hamburger-menu-1"></i>
        <i class="os-icon os-icon-email-2-at" title="os-icon os-icon-email-2-at"></i>
        <i class="os-icon os-icon-email-2-at2" title="os-icon os-icon-email-2-at2"></i>
        <i class="os-icon os-icon-fingerprint" title="os-icon os-icon-fingerprint"></i>
        <i class="os-icon os-icon-basic-2-259-calendar" title="os-icon os-icon-basic-2-259-calendar"></i>
        <i class="os-icon os-icon-arrow-2-up" title="os-icon os-icon-arrow-2-up"></i>
        <i class="os-icon os-icon-arrow-2-down" title="os-icon os-icon-arrow-2-down"></i>
        <i class="os-icon os-icon-bar-chart-down" title="os-icon os-icon-bar-chart-down"></i>
        <i class="os-icon os-icon-graph-down" title="os-icon os-icon-graph-down"></i>
        <i class="os-icon os-icon-pencil-1" title="os-icon os-icon-pencil-1"></i>
        <i class="os-icon os-icon-edit-3" title="os-icon os-icon-edit-3"></i>
        <i class="os-icon os-icon-edit-1" title="os-icon os-icon-edit-1"></i>
        <i class="os-icon os-icon-database-remove" title="os-icon os-icon-database-remove"></i>
        <i class="os-icon os-icon-pencil-2" title="os-icon os-icon-pencil-2"></i>
        <i class="os-icon os-icon-link-3" title="os-icon os-icon-link-3"></i>
        <i class="os-icon os-icon-email-forward" title="os-icon os-icon-email-forward"></i>
        <i class="os-icon os-icon-delivery-box-2" title="os-icon os-icon-delivery-box-2"></i>
        <i class="os-icon os-icon-wallet-loaded" title="os-icon os-icon-wallet-loaded"></i>
        <i class="os-icon os-icon-newspaper" title="os-icon os-icon-newspaper"></i>
        <i class="os-icon os-icon-window-content" title="os-icon os-icon-window-content"></i>
        <i class="os-icon os-icon-donut-chart-2" title="os-icon os-icon-donut-chart-2"></i>
        <i class="os-icon os-icon-text-input" title="os-icon os-icon-text-input"></i>
        <i class="os-icon os-icon-user-male-circle" title="os-icon os-icon-user-male-circle"></i>
    </div>
@endsection