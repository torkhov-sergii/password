<template>
    <aside>
        <div class="aside__controls">

            <div class="controls__close">закрити ✖</div>

            <div class="block-share">
                <div class="block-share__title">{{ trans('messages.filters.share') }}</div>

                <div class="block-share__links">
                    <social-sharing :url="baseUrl" inline-template>
                        <div>
                            <network network="facebook">
                                <div class="block-share__link m__fb"><i class="fab fa-facebook-f"></i></div>
                            </network>
                            <network network="googleplus">
                                <div class="block-share__link m__google"><i class="fab fa-google-plus-g"></i></div>
                            </network>
                            <network network="twitter">
                                <div class="block-share__link m__twitter"><i class="fab fa-twitter"></i></div>
                            </network>
                            <!--<network network="pinterest">-->
                                <!--<div class="block-share__link m__pinterest"><i class="fab fa-pinterest-p"></i></div>-->
                            <!--</network>-->
                        </div>
                    </social-sharing>
                </div>
            </div>

            <div v-if="whoms" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.whom') }}</div>
                <div class="type__items">
                    <div class="item"
                         v-for="whom in whoms"
                         v-on:click="selected_whom = whom.id"
                         v-bind:class="{ active: whom.id == selected_whom  }">{{ whom.name }}</div>
                </div>
            </div>

            <div v-if="durations" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.durations') }}</div>
                <div class="type__items">
                    <div class="item"
                         v-for="duration in durations"
                         v-on:click="selected_duration = duration.id"
                         v-bind:class="{ active: duration.id == selected_duration  }">{{ duration.name }}</div>
                </div>
            </div>

            <div v-if="chapters" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.chapters') }}</div>
                <div class="type__items">
                    <div class="item"
                         v-for="chapter in chapters"
                         v-on:click="selected_chapter = chapter.id, selected_tag = null"
                         v-bind:class="{ active: chapter.id == selected_chapter  }">{{ chapter.name }}</div>
                </div>
            </div>

            <div v-if="types" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.types') }}</div>
                <div class="type__items">
                    <div class="item"
                         v-for="type in types"
                         v-on:click="selected_type = type.id, selected_tag = null"
                         v-bind:class="[ type.slug, { 'active': type.id == selected_type } ]"> {{ type.name }}</div>
                </div>
            </div>

            <div v-if="difficulties" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.difficulties') }}</div>
                <div class="type__items">
                    <div class="item"
                         v-for="difficulty in difficulties"
                         v-on:click="selected_difficulty = difficulty.id"
                         v-bind:class="{ active: difficulty.id == selected_difficulty  }">{{ difficulty.name }}</div>
                </div>
            </div>

            <div v-if="tags" class="controls__type">
                <div class="type__title">{{ trans('messages.filters.tags') }}</div>
                <div class="type__tags">
                    <div class="tags__items">
                        <div
                            v-if="selected_tag"
                            v-on:click="selected_tag = null"
                            class="" style="text-decoration: underline; cursor: pointer; margin-bottom: 5px;">{{ trans('messages.filters.all-tags') }}</div>
                        <div
                            v-for="(tag, index) in tags"
                            v-show="index < 10 || showMoreTags"
                            v-on:click="selected_tag = {'id': tag.id, 'name': tag.name}, selected_chapter = null, selected_type = null"
                            v-bind:class="{ active: tag.id == selected_tag  }" class="item">{{ tag.name }}</div>
                    </div>

                    <div v-show="!showMoreTags"
                         v-on:click="showMoreTags = true" class="tags__more">{{ trans('messages.filters.more-tags') }}</div>
                </div>
            </div>

        </div>
    </aside>
</template>

<script>
    export default {
        props: ['type','baseUrl'],
        data: function() {
            return {
                chapters: {},
                types: {},
                whoms: {},
                durations: {},
                difficulties: {},
                tags: {},
                selected_chapter: null,
                selected_type: null,
                selected_whom: null,
                selected_duration: null,
                selected_difficulty: null,
                selected_tag: null,
                selected_author: null,
                showMoreTags: false,
                selected_sort: null,
            }
        },
        mounted: function () {
            var self = this;

            this.fetchFilters();

            eventHub.$on('selected_author', function (val) {
                self.selected_author = val;
            });

            eventHub.$on('selected_tag', function (val) {
                self.selected_tag = val;
            });

            // eventHub.$on('selected_sort', function (val) {
            //     self.selected_sort = val;
            // });
        },
        methods: {
            fetchFilters: function () {
                var self = this;

                axios.post(urlPrefix + '/api/filters', {
                    type: this.type,
                })
                    .then(function (response) {
                        self.chapters = response.data.chapters;
                        self.types = response.data.types;
                        self.whoms = response.data.whoms;
                        self.durations = response.data.durations;
                        self.difficulties = response.data.difficulties;
                        self.tags = response.data.tags;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        watch: {
            filters_ids: function() {
                eventHub.$emit('filters_ids', this.filters_ids);
            },
            filtersData: function() {
                eventHub.$emit('filtersData', this.filtersData);
            },
        },
        computed: {
            filters_ids: function () {
                var filters_ids = [];

                if(this.selected_chapter) filters_ids.push(this.selected_chapter);
                if(this.selected_type) filters_ids.push(this.selected_type);

                return filters_ids;
            },
            filtersData: function () {
                return {
                    whom:this.selected_whom,
                    duration:this.selected_duration,
                    difficulty:this.selected_difficulty,
                    tag:this.selected_tag,
                    author:this.selected_author,
                    //sort:this.selected_sort,
                };
            }
        }
    }
</script>
