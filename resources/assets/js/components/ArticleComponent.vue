<script>
    export default {
        props: {
        },
        data: function() {
            return {
                selected_author: null,
                selected_tag: null,
            }
        },
        mounted: function () {
        },
        methods: {
        },
        watch: {
            selected_author: function() {
                eventHub.$emit('selected_author', this.selected_author);
            },
            selected_tag: function() {
                eventHub.$emit('selected_tag', this.selected_tag);
            },
        },
        computed: {
        }
    }
</script>
