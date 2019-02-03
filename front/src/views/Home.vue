<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <div v-if="authenticated">
      <ProgramList v-if="user"></ProgramList>
      <div v-else>Veuillez vous connecter pour accéder au programmes</div>
    </div>
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
export default class Home extends Vue {
  get user() {
    return this.$store.state.user;
  }
  get authenticated() {
    return this.$store.state.authenticated;
  }
}
</script>
