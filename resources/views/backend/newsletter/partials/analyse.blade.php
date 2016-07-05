
@if(!$bloc->arrets_analyses->isEmpty())
    <!-- Bloc content-->
    <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff">
            <td colspan="3" height="35"></td>
        </tr><!-- space -->
        <tr>
            <td valign="top" width="375" class="resetMarge contentForm">
                <?php $i = 1; ?>
                @foreach($bloc->arrets_analyses as $analyse)
                    <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                        <tr>
                            <td valign="top" width="375" class="resetMarge contentForm">
                                <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                                <h3 style="text-align: left;">Analyse de l'arrêt {{ $bloc->reference }}</h3>

                                @if(!$analyse->analyse_authors->isEmpty())
                                    @foreach($analyse->analyse_authors as $analyse_authors)
                                        <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                                            <tr>
                                                <td valign="top" class="resetMarge">
                                                    <p style="text-align: left; color: #000; font-size: 13px;">{{ $analyse_authors->name }}</p>
                                                </td>
                                            </tr>
                                            <tr bgcolor="ffffff"><td colspan="3" height="5" class=""></td></tr><!-- space -->
                                        </table>
                                    @endforeach
                                @endif

                                <p class="abstract">{!! $analyse->abstract !!}</p>
                                <p><a href="{{ asset('files/analyses/'.$analyse->file) }}">Télécharger en pdf</a></p>
                            </td>
                        </tr>

                        @if( $bloc->arrets_analyses->count() > 1 && $bloc->arrets_analyses->count() > $i)
                            <tr bgcolor="ffffff"><td colspan="3" height="35" class=""></td></tr><!-- space -->
                        @endif

                        <?php $i++; ?>
                    </table>
                @endforeach

            </td>
            <td width="25" class="resetMarge"></td><!-- space -->
            <td align="center" valign="top" width="160" class="resetMarge">
                <!-- Categories -->
                <div class="resetMarge">
                    <a target="_blank" href="{{ url('jurisprudence') }}">
                        <img width="100" border="0" alt="Analyses" src="<?php echo asset('newsletter/pictos/analyse.png') ?>">
                    </a>
                </div>
            </td>
        </tr>
        <tr bgcolor="ffffff"><td colspan="3" height="5" class=""></td></tr><!-- space -->
    </table>
    <!-- Bloc content-->
@endif