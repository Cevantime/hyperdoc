<template>
  <div>
    <input type="text" name="search" @input="search" @change="search">
    <ul v-if="results.length > 0">
        <li :key="program.id" v-for="program of results">{{program.title}}</li>
    </ul>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import Program from "@/models/Program";
import programService from "@/services/ProgramService";

@Component
export default class ProgramSearch extends Vue {
  public results: Program[] = [];
  public searchTimeOut : any;

  search(e : any) {
    const search = e.target.value;
    
    if(this.searchTimeOut !== undefined) {
        clearTimeout(this.searchTimeOut);
    }
    if (search.length < 2) {
        this.results = [];
        return;
    }
    this.searchTimeOut = setTimeout(()=> {
        this.doSearch(search);
    }, 200);
  }

  doSearch(search : string) {
      programService.searchProgram(search).then((json : any)=> {
          this.results = json.data
      });
  }
}
</script>

<style scoped>
</style>