<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <ProgramList></ProgramList>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import ProgramList from '@/components/ProgramList.vue'; // @ is an alias to /src

@Component({
  components: {
    ProgramList,
  },
})
export default class Home extends Vue {}
</script>
