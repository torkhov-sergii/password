<template>
    <div>
        <div v-if="type == 'articles'">
            <div v-if="show" class="block-articles">
                <div class="articles__head m-black">
                    <div class="head__title">
                        <span v-if="filtersData && filtersData.author">{{ trans('messages.articles.title') }}: {{ filtersData.author.full_name }}</span>
                        <span v-else-if="filtersData && filtersData.tag">{{ trans('messages.articles.title-by-tag') }}: <span class="title__tag">{{ filtersData.tag.name }}</span></span>
                        <span v-else>{{ trans('messages.articles.title-all') }}</span>
                    </div>

                    <div class="articles__sort" v-bind:class="{ reversed: sort_reversed }">
                        <div v-on:click="sortMethod('date')"
                             v-bind:class="[{ active: sort == 'date' }]">Дата

                            <i class="fas fa-sort-amount-up"></i>
                            <i class="fas fa-sort-amount-down"></i>
                        </div>
                        <div v-on:click="sortMethod('popularity')"
                             v-bind:class="[{ active: sort == 'popularity' }]">Популярнiсть

                            <i class="fas fa-sort-amount-up"></i>
                            <i class="fas fa-sort-amount-down"></i>
                        </div>
                    </div>

                    <div class="articles-title-line__navigation-menu-toggler">
                        <span>Відкрити меню навігації</span>
                    </div>
                </div>

                <div class="articles__list">
                    <div v-for="item in items" class="articles__item animated fadeInLeft">

                        <div class="item__image">
                            <a v-bind:href="item.url">
                                <img class="image__main" v-bind:src="item.img">

                                <div v-if="item.type" class="image__type" v-bind:class="item.type"></div>
                            </a>
                        </div>

                        <div class="item__body">
                            <a v-bind:href="item.url" class="body__title">
                                {{ item.name }}
                            </a>

                            <div class="info__subtitle">
                                <span v-if="item.category" class="subtitle__category">{{ item.category }}</span>

                                <span class="subtitle__date">
                                    {{ item.date }}
                                </span>
                            </div>

                            <div class="body__annotation" v-html="item.text">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="category__empty" v-if="!items.length">
                    {{ trans('messages.items.empty') }}
                </div>

                <button
                        v-on:click="loadMore"
                        v-show="page < lastPage"
                        class="articles__more-button button button_blue" type='button'>{{ trans('messages.articles.more') }}
                </button>
            </div>
        </div>

        <div v-if="type == 'news' || type == 'news-mert'">
            <div v-if="show" class="block-articles">
                <div class="articles__head m-black">
                    <div v-if="type == 'news'" class="head__title">{{ trans('messages.news.title-all') }}</div>
                    <div v-if="type == 'news-mert'" class="head__title">{{ trans('messages.news-mert.title-all') }}</div>
                </div>

                <div class="articles__list">
                    <div v-for="item in items" class="articles__item animated fadeInLeft">

                        <div class="item__image">
                            <a v-bind:href="item.url">
                                <img class="image__main" v-bind:src="item.img">
                            </a>
                        </div>

                        <div class="item__body">
                            <a v-bind:href="item.url" class="body__title">
                                {{ item.name }}
                            </a>

                            <div class="info__subtitle">
                                <span v-if="type == 'news'" class="subtitle__category">{{ trans('messages.news.title') }}</span>
                                <span v-if="type == 'news-mert'" class="subtitle__category">{{ trans('messages.news-mert.title') }}</span>

                                <span class="subtitle__date">{{ item.date }}</span>
                            </div>

                            <div class="body__annotation" v-html="item.text">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="category__empty" v-if="!items.length">
                    {{ trans('messages.items.empty') }}
                </div>

                <button
                    v-on:click="loadMore"
                    v-show="page < lastPage"
                    class="articles__more-button button button_blue" type='button'>{{ trans('messages.news.more') }}</button>
            </div>
        </div>

        <div v-if="type == 'courses'">
            <div class="courses__list">
                <a v-for="item in items" v-bind:href="item.url" class="courses__item animated fadeInLeft">

                    <div class="item__image">
                        <img class="image__main" v-bind:src="item.img">
                    </div>

                    <div class="item__title">
                        {{ item.name }}
                    </div>

                    <div class="item__for">
                        {{ item.for }}
                    </div>

                    <div class="item__text">
                        {{ item.text2 }}
                    </div>

                    <div class="item__duration">
                        {{ trans('messages.courses.length') }}:  {{ item.string2 }}
                    </div>

                </a>
            </div>

            <div class="category__empty" v-if="!items.length">
                {{ trans('messages.items.empty') }}
            </div>

            <button
                v-on:click="loadMore"
                v-show="page < lastPage"
                class="courses__more-button button button_blue" type='button'>{{ trans('messages.courses.more') }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        //template: require('./template.html'),
        props: {
            type: null,
            initialShow: {
                default: true,
                type: Boolean
            }
        },
        data: function() {
            return {
                perPage: 3,
                page: 1,
                lastPage: null,
                items: [],
                filters_ids: [], //filters with relate
                filtersData: null, //filters custom
                show: this.initialShow,
                sort: 'date',
                sort_reversed: false,
            }
        },
        mounted: function () {
            var self = this;

            if(this.type == 'articles') this.perPage = 5;

            if(self.show) {
                this.fetchItems(true);
            }

            eventHub.$on('filters_ids', function (val) {
                self.filters_ids = val;
                self.fetchItems(true);
            });

            eventHub.$on('filtersData', function (val) {
                self.filtersData = val;
                self.fetchItems(true);
            });
        },
        watch: {
            filters_sort: function() {
                eventHub.$emit('filters_sort', this.filters_sort);
            },
        },
        methods: {
            fetchItems: function (clear) {
                var self = this;

                //показать статьи и скрыть статью
                self.show = true;
                $('.block-article').hide();

                $('.articles__list').showLoading();

                if(clear) {
                    self.page = 1;
                    $('.articles__item').removeClass('fadeInLeft').addClass('fadeOutRight');
                }

                axios.post(urlPrefix + '/api/' + self.type, {
                    page: this.page,
                    perPage: this.perPage,
                    filters_ids: this.filters_ids,
                    filtersData: this.filtersData,
                    filtersSort: this.filters_sort,
                })
                    .then(function (response) {
                        if(clear) self.items = [];

                        for(var key in response.data.items.data) {
                            self.items.push(response.data.items.data[key]);
                        }

                        self.lastPage = response.data.lastPage;

                        $('.articles__list').hideLoading();
                        if(clear) $('.articles__item').removeClass('fadeOutRight').addClass('fadeInLeft');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            loadMore: function () {
                this.page++;
                this.fetchItems(false);
            },
            sortMethod: function (key) {
                if (this.sort == key) {
                    if (this.sort_reversed) this.sort_reversed = false;
                    else this.sort_reversed = true;
                }
                else {
                    this.sort_reversed = false;
                }

                this.sort = key;

                this.fetchItems(true);
            }
        },
        computed: {
            filters_sort: function () {
                var filters_sort = {
                    'key': this.sort,
                    'direction': this.sort_reversed,
                };

                return filters_sort;
            },
        }
    }
</script>
