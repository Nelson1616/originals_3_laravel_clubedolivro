<template>
    <div class="book-item" style="display: inline">
        <h3 style="display: inline"> {{ item.title }}, </h3>
        de
        <span> {{ item.author }} </span>
    </div>
</template>

<script>
export default {
    props: ['item']
}
</script>