@include('backend.newsletter.partials.analyse' , ['bloc' => $bloc])

<!-- Bloc -->
<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="tableReset">
    <tr bgcolor="ffffff">
        <td colspan="3" height="35"></td>
    </tr><!-- space -->
    <tr align="center" class="resetMarge">
        <td class="resetMarge">
            <!-- Bloc content-->
            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                <tr>
                    <td valign="top" width="375" class="resetMarge">

                        <?php
                        $title = ($bloc->dumois ? 'Arrêt du mois : ' : '');
                        setlocale(LC_ALL, 'fr_FR.UTF-8');
                        ?>
                        <h3 style="text-align: left;font-family: sans-serif;">{{ $title }}{{ $bloc->reference }} du {{ $bloc->pub_date->formatLocalized('%d %B %Y') }}</h3>
                        <p class="abstract">{!! $bloc->abstract !!}</p>
                        <div>{!! $bloc->pub_text !!}</div>
                        <p><a href="{{ asset('files/arrets/'.$bloc->file) }}">Télécharger en pdf</a></p>
                    </td>
                    <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                    <td align="center" valign="top" width="160" class="resetMarge">
                       @if(!$bloc->arrets_categories->isEmpty() )
                            @include('backend.newsletter.partials.categories',['categories' => $bloc->arrets_categories])
                        @endif
                    </td>
                </tr>
            </table>
            <!-- Bloc content-->
        </td>
    </tr>
    <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
</table>
<!-- End bloc -->
