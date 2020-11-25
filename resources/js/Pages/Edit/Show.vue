<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <jet-form-section @submitted="savePost">
            <template #title>Upload Photo For Your Page</template>

            <template #form>
              <div class="col-span-6 sm:col-span-4">
                <jet-label for="photo" value="Upload Image For Home Page" />
                <input type="file" :v-model="form.photo" ref="photo" />
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
                Save post
              </jet-button>
            </template>
          </jet-form-section>

            <jet-input-error :message="form.error('content')" class="mt-2" />
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
  },

  props: ["page"],

  mounted: () => {
    console.log("it was mounted");
  },

  data() {
    return {
      content: this.page,
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
          content: '',
        },
        {
          bag: "savePost",
        }
      ),
      photo: null,
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

    savePost: function () {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }

      this.form.content = this.content;

      this.form
        .post(route("save"), {
          preserveScroll: true,
        })
        .then((res) => {
          console.log(response);
        });
    },
  },
};
</script>
