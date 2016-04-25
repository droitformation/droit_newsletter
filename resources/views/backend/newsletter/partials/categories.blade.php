<?php $sorted = $categories->sortBy('parent_id')->groupBy('parent_id'); ?>

<table border="0" width="160" align="center" cellpadding="0" cellspacing="0">
    @foreach($sorted as $parent => $categories)
        <tr align="center" style="margin: 0;padding: 0;">
            <td style="margin: 0;padding: 0;page-break-before: always;"  valign="top">
                @if(!empty($parent))
                    <?php $desired_parent = $parents->filter(function($item) use ($parent) { return $item->id == $parent; })->first(); ?>

                    @if($desired_parent->image)
                        <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                            <img width="130" border="0" alt="{{ $desired_parent->title }}" src="{{ asset('newsletter/pictos/'.$desired_parent->image) }}">
                        </a>
                    @else
                        <h3 style=" font-family: Arial,Helvetica,sans-serif;font-style: normal; line-height: 24px; color: #006eb4;font-size: 14px; margin: 10px 0;">{{ $desired_parent->title }}</h3>
                    @endif
                @endif
            </td>
        </tr>
        <tr align="center" style="margin: 0;padding: 0;">
            <td style="margin: 0;padding: 0;page-break-before: always;" valign="top">
                @foreach($categories as $categorie)
                   <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                        <img width="130" border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                   </a>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>