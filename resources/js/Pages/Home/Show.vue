<template>
    <div v-html="page" class="mt-16">
    </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";

export default {
  components: {
    JetApplicationLogo,
  },
  props: {
    page: String,
  },
};
</script>
