<template>
    <section v-if="program">
        <ProgramDetail :program="program"></ProgramDetail>
        <button @click="editProgram">Éditer le programme</button><br>
        <form v-if="editedProgram" @submit="save()">
            <p>
                <label for="code"><textarea name="code" id="code" cols="100" rows="10" v-model="editedProgram.code"></textarea></label>
            </p>
            <p>
                <input type="text" name="search" @input="search" @change="search">
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
import { Observable } from 'rxjs/Observable';
import { fromEvent } from 'rxjs/observable/fromEvent';

@Component({
  components: {
    ProgramDetail
  }
})
export default class Program extends Vue {
  public program: Program | null = null;
  public editedProgram: Program | null = null;
  public searchTimeOut : any;

  mounted() {
    ProgramService.getProgram(this.$route.params.slug, 'code,fullCode').then((rep: any) => {
      this.program = rep.data;
    });
  }

  editProgram() {
    this.editedProgram = Object.assign({}, this.program);
  }

  search(e : any) {
    const search = e.target.value;
    if(this.searchTimeOut !== undefined) {
        clearTimeout(this.searchTimeOut);
    }
    this.searchTimeOut = setTimeout(()=> {
        this.doSearch(search);
    }, 200);
  }

  doSearch(search : string) {

  }

  save() {

  }
}
</script>

<style lang="scss" scoped>
</style>
