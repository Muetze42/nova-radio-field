<template>
    <div :class="`text-${field.textAlign}`">
        <template v-if="fieldValue">
            <div v-if="shouldDisplayAsHtml" @click.stop v-html="fieldValue"></div>
            <span v-else class="whitespace-nowrap">{{ fieldValue }}</span>
        </template>
        <p v-else>&mdash;</p>
    </div>
</template>

<script>
import { FieldValue } from 'laravel-nova'

export default {
    mixins: [FieldValue],

    props: ['resourceName', 'field'],
}
</script>
