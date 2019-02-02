<template>
    <article v-if="program">
        <h1>{{ program.title }}</h1>
        <code><pre>{{ program.code }}</pre></code>
    </article>
</template>
<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import ProgramService from '@/services/ProgramService';
import Program from '@/models/Program';
import { Prop } from 'vue-property-decorator';

@Component
export default class ProgramDetail extends Vue {
    @Prop() private program! : Program;
    private programEdit : Program | null = null;

}
</script>