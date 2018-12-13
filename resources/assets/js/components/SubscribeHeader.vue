<template>
    <div>
        <div v-if="open">
            <transition name="fade">
                <div v-if="open" class="block-banner block-banner_subscribe">
                    <div v-on:click="close" class="block-banner__close">{{ trans('messages.banner-subscribe.close') }} <span>x</span></div>
                    <div class="block-banner__content">
                        <div class="block-banner__image"></div>
                        <a href="#block-subscribe" class="block-banner__text" v-html="trans('messages.banner-subscribe.subscribe')"></a>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                open: true,
            }
        },
        mounted: function () {
            //console.log(i18n.messages.sss);
            if(this.$cookie.get('subscribe_close')) this.open = false;
        },
        methods: {
            close: function() {
                this.$cookie.set('subscribe_close', true, 30);
                this.open = false;
            }
        }
    }
</script>
