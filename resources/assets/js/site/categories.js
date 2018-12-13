var AppCategories = function() {

    return {
        init: function(search_block) {
            //console.log('AppCategories inited');

            // Open/close category list
            $(document).on('click', '.articles-title-line__category-current, .articles-title-line__category-option', function(){
                if($(this).hasClass('articles-title-line__category-current')) {
                    $(this).toggleClass('articles-title-line__category-current_opened');
                } else {
                    $(this)
                        .closest('.articles-title-line__categories-menu')
                        .find('.articles-title-line__category-current')
                        .toggleClass('articles-title-line__category-current_opened')
                        .html($(this).html());
                }

                $(this).siblings('.articles-title-line__category-list').slideToggle(150);
                $(this).parent('.articles-title-line__category-list').slideToggle(150);
            });

            // // Choose option
            // $('.articles-title-line__category-option').on('click', function(){
            //     var chosen = $(this).html();
            //     var current = $(this).parent('.articles-title-line__category-list').siblings('.articles-title-line__category-current').html();
            //
            //     $(this).html(current);
            //     $(this).parent('.articles-title-line__category-list').siblings('.articles-title-line__category-current').html(chosen);
            //
            //     // This is for demonstration
            //     AppArticles.fadeOutArticles();
            //     setTimeout(function() {
            //         AppArticles.clearArticles();
            //         AppArticles.loadArticles(Math.floor(Math.random() * 14) + 1);
            //     }, 600);
            // });

        }
    };
}();

$(document).ready(function() {
    //if($('.articles-title-line__category-list').length > 0) {
        AppCategories.init();
    //}
});
