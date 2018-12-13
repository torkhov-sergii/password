<div class="b-locations">
    <div class="form-group">
        <div class="js__locations__fields-wrapper m-no-additional-fields">

            @if($object->locations->count())
                @foreach($object->locations as $location)
                    @include('vendor.locations.block.item', ['location'=>$location])
                @endforeach
            @else
                @include('vendor.locations.block.item', ['location'=>$object])
            @endforelse
        </div>
    </div>

    <div id="js__locations-map" data-locations="{{ $object->locations ? $object->locations->toJson() : '' }}" data-is_marker_draggable="true">
    </div>
</div>
