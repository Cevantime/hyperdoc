<template>
<section>
    <h1>Liste des programmes</h1>
    <ul>
        <li :key="program.id" v-for="program of programs">
            {{ program.title }}
        </li>
    </ul>
    <p>Nombre de programmes : {{ programCount }}</p>
</section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import Program from "@/models/Program";
import { programService } from '@/services/ProgramService';

@Component
export default class ProgramList extends Vue {
  public programs: Program[] = [];

  created() {
    programService.getPrograms().then(rep => {
      this.programs = rep.data.data;
    });
  }

  get programCount() {
    return this.programs.length;
  }
}
</script>

<style scoped>
</style>