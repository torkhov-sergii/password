<div class="form-group js__locations__item @if($location->manually) m-manually @endif">
    <div class="form-group js__item__automatically-fields">
        {!! Form::text('locations[location][]', $location->location, array(
            'class' => 'js__item__location-input form-control',
            'autocomplete' => 'off',
        )) !!}
        <label class="error js__item__location-input-error" style="display: none">{{ trans('main.locations.location_cant_found_please_fill_manually') }}</label>
    </div>

    <div class="js__item__manually-fields">
        <div class="form-group">
            <input type="text" class="js__item__country-input form-control" name="locations[country][]" value="{{ $location->country }}" placeholder="{{ trans('main.locations.country') }}">
        </div>

        <div class="form-group">
            <input type="text" class="js__item__city-input form-control" name="locations[city][]" value="{{ $location->city }}" placeholder="{{ trans('main.locations.city') }}">
        </div>

        <div class="form-group">
            <input type="text" class="js__item__postal-input form-control" name="locations[postal_code][]" value="{{ $location->postal_code }}" placeholder="{{ trans('main.locations.postal_code') }}">
        </div>
    </div>

    <input type="hidden" class="js__item__lat-input" name="locations[lat][]" value="{{ $location->lat }}">
    <input type="hidden" class="js__item__lng-input" name="locations[lng][]" value="{{ $location->lng }}">
    <input type="hidden" class="js__item__manually-input" name="locations[manually][]" value="{{ $location->manually }}">
</div>