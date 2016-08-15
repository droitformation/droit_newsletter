@if(!$analyse->authors->isEmpty())
    @foreach($analyse->authors as $author)
        <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" width="375" class="resetMarge">
                    <h3 style="text-align: left;font-family: sans-serif; color:#000; font-size: 13px; font-weight: normal;">{{ $author->name }}</h3>
                </td>
            </tr>
            <tr bgcolor="ffffff"><td colspan="3" height="15" class=""></td></tr><!-- space -->
        </table>
    @endforeach
@endif