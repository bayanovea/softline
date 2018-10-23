<template>
    <div class="contact">
        <div>
            <input name="contact--choose" type="radio" @click="chooseContact">
        </div>

        <div>{{ data.number }}</div>

        <div>
            {{ data.first_name }}
            <input v-if="isChosen" v-model="data.first_name"/>
        </div>

        <div>
            {{ data.last_name }}
            <input v-if="isChosen" v-model="data.last_name"/>
        </div>

        <div>
            {{ data.second_name }}
            <input v-if="isChosen" v-model="data.second_name"/>
        </div>

        <div>
            {{ data.phone }}
            <input v-if="isChosen" v-model="data.phone"/>
        </div>

        <div>
            {{ data.email }}
            <input v-if="isChosen" v-model="data.email"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                isChosen: false
            }
        },

        methods: {
            chooseContact() {
                this.$root.$emit('chooseContact', this.data.id);
                this.isChosen = true;
            },
            unchooseContact() {
                this.isChosen = false;
            },
        },

        mounted() {
            this.$root.$on('chooseContact', this.unchooseContact);
        }
    }
</script>

<style scoped>
    .contact {
        display: flex;
        flex-direction: row;
    }

    .contact div {
        border: 1px solid #ccc;
        padding: 10px;
        width: 120px;
    }
</style>
