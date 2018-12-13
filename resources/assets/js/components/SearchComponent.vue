<template>
    <div>
        <div class="block-search m-faq">
            <div class="search__wrapper">
                <div class="search__input-container">
                    <input v-model="search_string" :placeholder="trans('messages.search.placeholder')">
                    <img class="search__icon" src="/images/search-icon.png">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                search_string: null,
            }
        },
        watch: {
            search_string: function() {
                eventHub.$emit('search_string', this.search_string);
            },
        },
    }
</script>
