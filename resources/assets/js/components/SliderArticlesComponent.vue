<template>
    <div class="page-block block-articles-slider" data-av-animation="fadeInUp">
        <div class="container">

            <div class="slider__head">
                <div class="head__title">{{ trans('messages.articles-slider.title') }}</div>

                <div class="articles-title-line__categories-menu">
                    <div class="articles-title-line__category-current">
                        {{ trans('messages.articles-slider.option.all') }}
                    </div>
                    <div class="js__articles-carousel-select articles-title-line__category-list">
                        <div v-on:click="selected_type = null, selected_type_slug = null" class="articles-title-line__category-option" data-type="">{{ trans('messages.articles-slider.option.all') }}</div>
                        <div v-on:click="selected_type = 28, selected_type_slug = 'zamovniku'" class="articles-title-line__category-option">{{ trans('messages.articles-slider.option.zamovniku') }}</div>
                        <div v-on:click="selected_type = 30, selected_type_slug = 'uchasniku'" class="articles-title-line__category-option">{{ trans('messages.articles-slider.option.uchasniku') }}</div>
                        <div v-on:click="selected_type = 31, selected_type_slug = 'gromadskosti'" class="articles-title-line__category-option">{{ trans('messages.articles-slider.option.gromadskosti') }}</div>
                        <div v-on:click="selected_type = 32, selected_type_slug = 'intervyu'" class="articles-title-line__category-option">{{ trans('messages.articles-slider.option.intervyu') }}</div>
                        <div v-on:click="selected_type = 33, selected_type_slug = 'instrukcii'" class="articles-title-line__category-option">{{ trans('messages.articles-slider.option.instrukcii') }}</div>
                    </div>
                </div>
            </div>

            <div v-show="items.length" class="slider__container owl-carousel">

            </div>

            <div class="slider__empty" v-show="!items.length">
                {{ trans('messages.articles-slider.empty') }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data: function() {
            return {
                owl: null, //carousel
                items: [],
                selected_type: null,
                selected_type_slug: null
            }
        },
        mounted: function () {
            this.initSlider();
            this.fetchItems();
        },
        methods: {
            initSlider: function () {
                // Initialize Owl Carousel
                this.owl = $('.slider__container.owl-carousel').owlCarousel({
                    nav: true,
                    responsive:{
                        0: {
                            items: 1
                        },
                        800: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        },
                        1440: {
                            items: 4
                        }
                    }
                });

                $('.owl-prev, .owl-next').html('');
            },
            fetchItems: function () {
                var self = this;

                axios.post(urlPrefix + '/api/slider-articles', {
                    type: this.selected_type,
                })
                    .then(function (response) {
                        self.items = [];
                        var arr = response.data.items.data;

                        for (var i=0;i<=100;i++) {
                            self.owl.trigger('remove.owl.carousel', i );
                        }

                        for(var key in arr) {
                            self.items.push(arr[key]);

                            if(self.selected_type) {
                                arr[key].category_slug = self.selected_type_slug;
                            }

                            self.owl.trigger('add.owl.carousel', [
                                jQuery('' +
                                    '<a href="'+ arr[key].url +'" class="slider__item m-'+ arr[key].category_slug +'">' +
                                    '<img src="'+ arr[key].img +'"> ' +
                                    '<div class="item__category">'+ arr[key].category +'</div> ' +
                                    '<div class="item__info">' +
                                        '<div class="info__title">'+ arr[key].name +'</div> ' +
                                        '<div class="info__date">'+ arr[key].date +'</div>' +
                                    '</div>' +
                                    '</a>')
                            ]);
                        }

                        self.owl.trigger('refresh.owl.carousel');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        watch: {
            selected_type: function() {
                this.fetchItems();
            },
        },
        computed: {
        }
    }
</script>
