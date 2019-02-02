<template>
<section>
    <h1>Liste des programmes</h1>
    <ul v-if="programs.length > 0">
        <li :key="program.id" v-for="program of programs">
            <router-link :to="{ name: 'program', params: { slug: program.slug }}">{{ program.title}}</router-link>
        </li>
    </ul>
    <div v-else>{{ message }}</div>
    <p>Nombre de programmes : {{ programCount }}</p>
</section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Program from "@/models/Program";
import programService from '@/services/ProgramService';

@Component
export default class ProgramList extends Vue {
  public programs: Program[] = [];
  public message = 'Aucun programe à ce jour';

  created() {
    programService.getPrograms().then((rep : any) => {
      this.programs = rep.data;
    }).catch(e => {
      console.log(e.message);
      this.message = 'Impossible de charger la liste des programmes';
    });
  }

  get programCount() {
    return this.programs.length;
  }
}
</script>

<style scoped>
</style>