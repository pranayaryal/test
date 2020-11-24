<template>
  <jet-form-section @submitted="saveImage">
    <template #title>Upload Photo For Your Page</template>
    <template #description>Save Image</template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="photo" value="Upload Image For Home Page" />
        <input
          type="file"
          :v-model="form.photo"
          ref="photo"
        />
        <jet-input-error :message="form.error('photo')" class="mt-2" />
      </div>
    </template>
    <template #actions>
      <jet-action-message :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </jet-action-message>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save Image
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";

export default {
  components: {
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetActionMessage,
    JetButton,
  },

  data() {
    return {
      form: this.$inertia.form(
        {
          photo: null,
          testing: "",
        },
        {
          bag: "saveImage",
        }
      ),
      photo: null,
    };
  },

  mounted: () => console.log("upload mounted"),

  methods: {
    saveImage() {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }
      this.form
        .post(route("image.update"), {
          preserveScroll: true,
        })
        .then((res) => {
          console.log(response);
        });
    },

  },
};
</script>
