<template>
    <section v-if="program">
        <ProgramDetail :program="program"></ProgramDetail>
        <button @click="editProgram">Éditer le programme</button><br>
        <form v-if="editedProgram" @submit="save()">
            <p>
                <label for="code"><textarea name="code" id="code" cols="100" rows="10" v-model="editedProgram.code"></textarea></label>
            </p>
            <p>
                Rechercher un programme : <ProgramSearch></ProgramSearch>
            </p>
            <button type="submit">Modifier</button>
        </form>
        <p>
            <router-link :to="{name : 'home'}">Revenir à la page d'accueil</router-link>
        </p>
    </section>
</template>
<script lang="ts">
import Vue from "vue";
import Component from "vue-class-component";
import ProgramService from "@/services/ProgramService";
import ProgramDetail from "@/components/ProgramDetail.vue";
import ProgramSearch from "@/components/ProgramSearch.vue";
import Prgr from '@/models/Program';
import { Observable } from 'rxjs/Observable';
import { fromEvent } from 'rxjs/observable/fromEvent';

@Component({
  components: {
    ProgramDetail,
    ProgramSearch
  }
})
export default class Program extends Vue {
  public program: Program | null = null;
  public editedProgram: Program | null = null;

  mounted() {
    ProgramService.getProgram(this.$route.params.slug, 'code,fullCode').then((rep: any) => {
      this.program = rep.data;
    });
  }

  editProgram() {
    this.editedProgram = Object.assign({}, this.program);
  }

  programSelected(program : Prgr) {
      console.log("program selected : " + program.title);
  }

  save() {
      
  }
}
</script>

<style lang="scss" scoped>
</style>
