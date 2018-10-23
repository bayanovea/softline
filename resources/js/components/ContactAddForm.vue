<template>
    <form class="form" action="{{ data.routeContactStore }}" method="POST">
        @csrf

        <fieldset>
            <label for="first_name">@lang('contact.first_name')</label>
            <input name="first_name" />
        </fieldset>

        <fieldset>
            <label for="second_name">@lang('contact.second_name')</label>
            <input name="second_name" />
        </fieldset>

        <fieldset>
            <label for="last_name">@lang('contact.last_name')</label>
            <input name="last_name" />
        </fieldset>

        <fieldset>
            <label for="phone">@lang('contact.phone')</label>
            <input name="phone" />
        </fieldset>

        <fieldset>
            <label for="email">@lang('contact.email')</label>
            <input name="email" />
        </fieldset>

        <button>Send</button>
    </form>
</template>

<script>
    export default {

    }
</script>

<style scoped>
</style>