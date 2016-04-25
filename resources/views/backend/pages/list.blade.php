<table class="table" style="margin-bottom: 0px;" id="generic">
    <thead>
    <tr>
        <th class="col-sm-1">Action</th>
        <th class="col-sm-2">Titre</th>
        <th class="col-sm-1">Ouvrage</th>
        <th class="col-sm-2">Page</th>
        <th class="col-sm-1"></th>
    </tr>
    </thead>
    <tbody class="selects">

    @if(!empty($pages))
        @foreach($pages as $page)
            <tr>
                <td><a class="btn btn-sky btn-sm" href="{{ url('admin/page/'.$page->id) }}">&Eacute;diter</a></td>
                <td><strong>{{ $page->title or '' }}</strong></td>
                <td>{{ $page->ouvrage }}</td>
                <td>{{ $page->page }}</td>
                <td class="text-right">
                    <form action="{{ url('admin/page/'.$page->id) }}" method="POST" class="form-horizontal">
                        <input type="hidden" name="_method" value="DELETE">
                        {!! csrf_field() !!}
                        <button data-action="page: {{ $page->title }}" class="btn btn-danger btn-sm deleteAction">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif

    </tbody>
</table>