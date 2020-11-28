<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <jet-form-section @submitted="saveContactDetails">

            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="photo" value="Upload Image For Contact Page" />
                <input
                  type="file"
                  class="hidden"
                  ref="photo"
                  @change="updatePhotoPreview"
                />
                <jet-input-error :message="form.error('photo')" class="mt-2" />
                <jet-input-error v-if="photoDeleted"
                :message="photoDeleted ? 'photo deleted, refresh page' : ''" class="mt-2" />
                <!-- Current page Photo -->
                <div class="mt-2" v-show="!photoPreview">
                  <img
                    :src="publicImagePath"
                    alt="Current Page Photo"
                    class="h-20 w-20 object-cover"
                  />
                </div>

                <!-- New page Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                  <span
                    class="block rounded-full w-20 h-20"
                    :style="
                      'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                      photoPreview +
                      '\');'
                    "
                  >
                  </span>
                </div>
                <jet-secondary-button
                  class="mt-2 mr-2"
                  type="button"
                  @click.native.prevent="selectNewPhoto"
                >
                  Select A New Photo
                </jet-secondary-button>
                <jet-secondary-button
                  type="button"
                  class="mt-2"
                  @click.native.prevent="deletePhoto"
                  v-if="pagePhotoPath"
                >
                  Remove Photo
                </jet-secondary-button>
              </div>

              <!-- Phone -->
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Phone" />
                <jet-input
                  id="phone"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.phone"
                  autocomplete="phone"
                />
                <jet-input-error :message="form.error('phone')" class="mt-2" />
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

              <!-- Title -->
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="title" value="Meta Title" />
                <jet-input
                  id="title"
                  type="title"
                  class="mt-1 block w-full"
                  v-model="form.title"
                />
                <jet-input-error :message="form.error('title')" class="mt-2" />
              </div>
              <!-- Description -->
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="description" value="Meta Description" />
                <jet-input
                  id="description"
                  type="description"
                  class="mt-1 block w-full"
                  v-model="form.description"
                />
                <jet-input-error :message="form.error('description')" class="mt-2" />
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
                Save Contact Details
              </jet-button>
            </template>
          </jet-form-section>

        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UploadPhoto from "../Edit/PhotoUpload";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import Content from "../content";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  components: {
    AppLayout,
    UploadPhoto,
    JetButton,
    JetFormSection,
    JetInput,
    JetLabel,
    JetInputError,
    JetActionMessage,
    JetSecondaryButton,
  },

  props: ["pagePhotoPath", "email", "phone", "photoDeleted", "title", "description"],

  mounted: () => {
    console.log("show.vue was mounted");
  },

  data() {
    return {
      content: this.pageHtml ? this.pageHtml : "",
      publicImagePath: `/storage/${this.pagePhotoPath}`,

      form: this.$inertia.form(
        {
          photo: null,
          email: this.email,
          phone: this.phone,
          title: this.title,
          description: this.description
        },
        {
          bag: "saveContactDetails",
        }
      ),
      photo: null,
      photoPreview: null,
    };
  },

  methods: {
    selectNewPhoto() {
      this.$refs.photo.click();
    },

    updatePhotoPreview() {
      const reader = new FileReader();

      reader.onload = (e) => {
        this.photoPreview = e.target.result;
      };

      reader.readAsDataURL(this.$refs.photo.files[0]);
    },

    saveContactDetails: function () {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }

      this.form
        .post(route("saveContact"), {
          preserveScroll: true,
        })
        .then((res) => {
          console.log(response);
        });
    },
    deletePhoto() {
      this.$inertia
        .post(route("contactPhotoDelete"), {
          preserveScroll: true,
        })
        .then(() => {
          this.photoPreview = null;
        });
    },
    deletePost() {
      this.$inertia
        .post(route("deletePost"), {
          preserveScroll: true,
        })
        .then(() => {
          this.photoPreview = null;
          window.location('/edit-contact')
        });
    },
  },
};
</script>
