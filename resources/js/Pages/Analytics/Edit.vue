<template>
  <app-layout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
          <template>
            <jet-form-section @submitted="saveAnalytics">
              <template #title>Analytics</template>
              <template #description> Fill In Or Edit Your Analytics Details </template>

              <template #form>
                <!-- Google Analytics -->
                <div class="col-span-6 sm:col-span-4">
                  <jet-label for="ga" value="Google Analytics" />
                  <jet-input
                    id="ga"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.ga"
                    autocomplete="name"
                  />
                  <jet-input-error :message="form.error('ga')" class="mt-2" />
                </div>

                <!-- Facebook Pixel Id -->
                <div class="col-span-6 sm:col-span-4">
                  <jet-label for="fbPixelId" value="Facebook Pixel Id" />
                  <jet-input
                    id="fbPixelId"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.fbPixelId"
                    autocomplete="name"
                  />
                  <jet-input-error
                    :message="form.error('fbPixelId')"
                    class="mt-2"
                  />
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
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetTextInput from "@/Jetstream/TextInput";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetButton from "@/Jetstream/Button";

export default {
  metaInfo: {
    title: 'Analytics Edit',
    meta: [
      { name: 'robots', content: 'noindex'}
    ]
  },
  components: {
    AppLayout,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    JetTextInput,
  },

  data() {
    return {
      form: this.$inertia.form(
        {
          ga: this.ga ? this.ga : '',
          fbPixelId: this.fbPixelId ? this.fbPixelId : '',
        },
        {
          bag: "saveAnalytics",
          resetOnSuccess: false,
        }
      ),
    };
  },

  props: {
    ga: String,
    fbPixelId: String,
  },

  mounted: () => console.log(`you are in home page`),

  methods: {
    saveAnalytics(){
      this.form
        .post(route("analytics.post"), {
          preserveScroll: true,
        })
        .then((res) => {
          this.form.ga = "";
          this.form.fbPixelId = "";
        });
    },
  },
};
</script>
