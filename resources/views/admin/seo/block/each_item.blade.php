<tr>
    <td>
        {{ $item['id'] }}
    </td>
    <td class="bold" style="padding-left: {{ ($item['depth']-0.5)*20 }}px">
        {{ $item['name'] }}
    </td>
    <td>
        {!! Form::text($item['id'].'[title]', $item->title, array('class' => 'form-control')) !!}
    </td>
    <td>
        {!! Form::text($item['id'].'[description]', $item->description, array('class' => 'form-control')) !!}
    </td>
    <td>
        {{--{!! Form::text($item['id'].'[itemtype]', $item->itemtype, array('class' => 'form-control')) !!}--}}
        {!! Form::select($item['id'].'[itemtype]', ['Article'=>'Article','Blog'=>'Blog','Book'=>'Book','Clip'=>'Clip','Code'=>'Code','Comment'=>'Comment','CreativeWorkSeason'=>'CreativeWorkSeason','CreativeWorkSeries'=>'CreativeWorkSeries','DataCatalog'=>'DataCatalog','Dataset'=>'Dataset','Diet'=>'Diet','EmailMessage'=>'EmailMessage','Episode'=>'Episode','ExercisePlan'=>'ExercisePlan','Game'=>'Game','Map'=>'Map','MediaObject'=>'MediaObject','Movie'=>'Movie','MusicComposition'=>'MusicComposition','MusicPlaylist'=>'MusicPlaylist','MusicRecording'=>'MusicRecording','Painting'=>'Painting','Photograph'=>'Photograph','PublicationIssue'=>'PublicationIssue','PublicationVolume'=>'PublicationVolume','Question'=>'Question','Recipe'=>'Recipe','Review'=>'Review','Sculpture'=>'Sculpture','Season'=>'Season','Series'=>'Series','SoftwareApplication'=>'SoftwareApplication','SoftwareSourceCode'=>'SoftwareSourceCode','TVSeason'=>'TVSeason','TVSeries'=>'TVSeries','VisualArtwork'=>'VisualArtwork','WebPage'=>'WebPage','WebPageElement'=>'WebPageElement','WebSite'=>'WebSite'], $item->itemtype, array('class' => 'form-control')) !!}
    </td>
    {{--<td>--}}
        {{--{!! Form::text($item['id'].'[keywords]', $item->keywords, array('class' => 'form-control')) !!}--}}
    {{--</td>--}}
</tr>

@if (count($item['children']) > 0)
    @foreach($item['children'] as $item)
        @include('admin.seo.block.each_item', $item)
    @endforeach
@endif


