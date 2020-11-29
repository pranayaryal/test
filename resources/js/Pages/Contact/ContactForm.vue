<template>
  <jet-form-section @submitted="postContact">
    <div></div>
    <template #title> BeMo Academic Consulting Inc. </template>

    <template #description>
      <p>Email: {{ email }}</p>
      <p>Phone: {{ phone }}</p>
    </template>

    <template #form>
      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="name" value="Name" />
        <jet-input
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          autocomplete="name"
        />
        <jet-input-error :message="form.error('name')" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="email" value="Email" />
        <jet-input
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
        />
        <jet-input-error :message="form.error('email')" class="mt-2" />
      </div>

      <!-- How can we help you -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="help" value="How can we help you" />
        <textarea
          id="help"
          type="textarea"
          class="form-input mt-1 block w-full"
          v-model="form.help"
        />
        <jet-input-error :message="form.error('help')" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Submit
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetTextInput from "@/Jetstream/TextInput";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    JetTextInput,
  },

  metaInfo: {
    meta: [{ 
      name: 'robots',
      content: this.noindex ? 'noindex' : ''
    }],
  },


  props: ["user", "email", "phone", "noindex"],

  data() {
    return {
      form: this.$inertia.form(
        {
          name: "",
          email: "",
          help: "",
        },
        {
          bag: "postContact",
          resetOnSuccess: false,
        }
      ),

      photoPreview: null,
      successMessage: null,
    };
  },

  mounted: () => console.log("contact form mounted"),

  methods: {
    postContact() {
      this.form
        .post(route("contact.post"), {
          preserveScroll: true,
        })
        .then((res) => {
          this.form.name = "";
          this.form.email = "";
          this.form.help = "";
          console.log(res.data);
        });
    },
  },
};
</script>
