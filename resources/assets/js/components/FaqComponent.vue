<template>
    <div>
        <div class="category__item" v-for="item in sortedItems">
            <a v-bind:href="'/faq/'+item.slug" class="item__question">
                {{ item.name }}
            </a>

            <div class="item__answer">
                {{ item.text }}
            </div>
        </div>

        <div class="category__empty" v-if="!sortedItems.length">
            {{ trans('messages.faq.empty') }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data: function() {
            return {
                //items: items,
                search_string: '',
            }
        },
        methods: {
            // isVisible: function(item) {
            //     return item.name.indexOf(this.search_string) > -1;
            // },
        },
        mounted: function () {
            var self = this;

            eventHub.$on('search_string', function (item) {
                self.search_string = item;
            });
        },
        computed: {
            sortedItems: function () {
                var self = this;
                var itemsTmp = this.items;

                itemsTmp = itemsTmp.filter(function(item) {
                    //return (filterRooms.indexOf(apartment.rooms) !== -1);
                    return (item.name.indexOf(self.search_string) !== -1);
                });

                return itemsTmp;
            }

        }
    }
</script>
