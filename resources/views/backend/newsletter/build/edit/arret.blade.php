<div class="edit_content">

    @include('backend.newsletter.partials.analyse' , ['bloc' => $bloc])

    <!-- Bloc content-->
    <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff">
            <td colspan="3" height="35">
                <div class="pull-right btn-group btn-group-xs">
                    <button class="btn btn-danger deleteContent deleteContentBloc" data-id="{{ $bloc->idItem }}" data-action="{{ $bloc->reference }}" type="button">&nbsp;×&nbsp;</button>
                </div>
            </td>
        </tr><!-- space -->
        <tr>
            <td valign="top" width="375" class="resetMarge contentForm">
                <div>
                    <?php $title = ($bloc->dumois ? 'Arrêt du mois : ' : ''); ?>
                    <h3 style="text-align: left;">{{ $title }}{{ $bloc->reference }} du {{ $bloc->pub_date->formatLocalized('%d %B %Y') }}</h3>
                    <p class="abstract">{!! $bloc->abstract !!}</p>
                    <div>{!! $bloc->pub_text !!}</div>
                    <p><a href="{{ asset('files/arrets/'.$bloc->file) }}">Télécharger en pdf</a></p>
                </div>
            </td>
            <td width="25" class="resetMarge"></td><!-- space -->
            <td align="center" valign="top" width="160" class="resetMarge">
                <!-- Categories -->
                <div class="resetMarge">
                   @if(!$bloc->arrets_categories->isEmpty())
                       @include('backend.newsletter.partials.categories',['categories' => $bloc->arrets_categories])
                   @endif
                </div>
            </td>
        </tr>
        <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
    </table>
    <!-- Bloc content-->

</div>
