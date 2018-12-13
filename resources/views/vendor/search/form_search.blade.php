
    {{--<input name="search" type="text" class="form-control search_input" placeholder="{{ $search or "Search" }}">--}}
    {{--<span class="input-group-btn">--}}
        {{--<button class="btn-u search_button" type="button">{!! $button or "Go" !!}</button>--}}
    {{--</span>--}}

    <div class="b-search">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control search_input" placeholder="{{ $slug or "Search" }}" aria-describedby="search" @if(isset($slug) && $slug != 'Enter your text') value="{{ $slug }}" @endif>
                <button type="submit" class="input-group-addon search_button" id="search"></button>
            </div>
        </div>

        @if(isset($count) && $count > 0)
            <div class="search__results">
                {{ $count }} results
            </div>
        @endif
    </div>