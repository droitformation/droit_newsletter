<tr>
    <td width="600" align="center" valign="top">

        <!-- Logos and header img -->
        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="tableReset">
            <tr class="resetMarge" style="display:block;">
                <td width="600" style="margin: 0;padding: 0;display:block;border: 1px solid #ededed; border-bottom: 0;">
                    <a href="{{ url('/') }}">
                        <img style="display:block;margin: 0;padding: 0;" alt="{{ $infos->newsletter->from_name }}" src="{{ asset('newsletter/'.$infos->newsletter->logos ) }}" />
                    </a>
                </td>
            </tr>
            <tr class="resetMarge" style="display:block;">
                <td width="600" class="resetMarge" style="margin: 0;padding: 0;display:block;border: 1px solid #ededed; ">
                    <img alt="{{ $infos->newsletter->from_name }}" src="{{ asset('newsletter/'.$infos->newsletter->header ) }}" />
                </td>
            </tr>
        </table>
        <!-- End logos and header img -->

    </td>
</tr>
