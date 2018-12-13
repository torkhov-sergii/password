var AppSearch = function() {

    var searchInput;
    var searchResult;
    var search_string;
    var slideEnable = true;

    var initVars = function () {
        searchInput = $('#search__input');
        searchResult = $('.search__result');
        searchButton = $('.search__icon');
    };

    // Live Search
    // On Search Submit and Get Results
    var search = function() {
        search_string = searchInput.val();

        if(search_string !== ''){
            $.ajax({
                url: urlPrefix + '/api/search',
                type: 'POST',
                data: { search_string: search_string}, //this can be more complex if needed
                cache: false,
                success: function(data){
                    //at each request - every written letter is request, firstly we delete old results, and fetch new ones.
                    searchResult.html(data.html);
                    if(slideEnable) searchResult.slideDown();
                }
            });
        }
        return false;
    };

    var initLiveSearch = function () {
        searchInput.on("keyup", function(e) {
            // Set Timeout
            clearTimeout($.data(this, 'timer'));
            // Set Search String
            var search_string = $(this).val();
            // Do Search
            if (search_string == '') {
                if(slideEnable) $(searchResult).slideUp();
            }else{
                $(this).data('timer', setTimeout(search, 100));
            };
        });

        //close modal if click outside
        $('html').mouseup(function(e) {
            var container = searchResult;

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                if(slideEnable) $(searchResult).slideUp();
            }
        });
    };

    var redirectToSearchPage = function () {
        search_string = searchInput.val();

        window.location.replace("/search/"+search_string);
    };

    return {
        init: function(search_block) {
            //console.log('AppSearch inited');

            initVars();
            initLiveSearch();

            $('.search__example').on('click', function() {
                search_block.find(searchInput).val($(this).text());
                search();
            });

            $(searchButton).on('click', function() {
                redirectToSearchPage();
            });

            $(searchInput).keypress(function (e) {
                if (e.which == 13) {
                    redirectToSearchPage();
                }
            });

            if($(searchInput).hasClass('slideDisable')) {
                slideEnable = false;
            }

            if ($(window).width() < 430) {
                search_block.find(searchInput).attr('placeholder', 'введіть запит')
            }
        }
    };
}();

$(document).ready(function() {
    if($('.block-search').length > 0) {
        AppSearch.init($(this));
    }
});
