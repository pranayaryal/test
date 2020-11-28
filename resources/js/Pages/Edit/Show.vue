<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <jet-form-section @submitted="savePost">

            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="photo" value="Upload Image For Home Page" />
                <input
                  type="file"
                  class="hidden"
                  ref="photo"
                  @change="updatePhotoPreview"
                />
                <jet-input-error v-if="!photoPreview" :message="form.error('photo')" class="mt-2" />
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
                Save post
              </jet-button>
            </template>
          </jet-form-section>

          <jet-button @click.native.prevent="deletePost" v-if="pageHtml">
            Delete post
            </jet-button>
          <jet-input-error :message="form.error('content')" class="mt-2 ml-4" />
          <quill-editor
            ref="editor"
            v-model="content"
            :options="editorOption"
            @blur="onEditorBlue($event)"
            @focus="onEditorFocus($event)"
            @ready="onEditorReady($event)"
            class="mt-4"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import AppLayout from "@/Layouts/AppLayout";
import UploadPhoto from "./PhotoUpload";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import Content from "../content";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

import { quillEditor } from "vue-quill-editor";
export default {
  components: {
    quillEditor,
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

  props: ["pageHtml", "pagePhotoPath", "title", "description"],

  mounted: () => {
    console.log("show.vue was mounted");
  },

  data() {
    return {
      content: this.pageHtml ? this.pageHtml : "",
      publicImagePath: `/storage/${this.pagePhotoPath}`,
      editorOption: {
        theme: "snow",
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike", "h1"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ list: "ordered" }, { list: "bullet" }],
          ],
        },
      },

      form: this.$inertia.form(
        {
          photo: null,
          content: "",
          title: this.title,
          description: this.description
        },
        {
          bag: "savePost",
        }
      ),
      photo: null,
      photoPreview: null,
    };
  },

  methods: {
    onEditorBlue(editor) {
      console.log("editor blur", editor);
    },
    onEditorFocus(editor) {
      console.log("editor focussed", editor);
    },
    onEditorReady(editor) {
      console.log("editor ready", editor);
    },

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

    savePost: function () {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }

      this.form.content = this.content;

      this.form
        .post(route("saveHome"), {
          preserveScroll: true,
        })
        .then((res) => {
          console.log(response);
        });
    },
    deletePhoto() {
      this.$inertia
        .post(route("homePhotoDelete"), {
          preserveScroll: true,
        })
        .then(() => {
          this.photoPreview = null;
        });
    },
    deletePost(){
      this.$inertia
        .post(route('deletePost'), {
          preserveScroll: true,
        })
        .then(() => {
          this.photoPreview = null;
        });
    }
  },
};
</script>
