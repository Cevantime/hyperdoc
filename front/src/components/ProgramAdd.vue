<template>
<form>
    
</form>
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