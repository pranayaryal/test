<template>
  <app-layout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <upload-photo></upload-photo>

          <h1>Edit Page Content</h1>
          <edit-menu-bar :editor="editor" />
          <editor-content
            :editor="editor"
            class="mt-4 p-4 focus:ring-blue-600"
          />

          <button
            @click="savePost"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          >
            Save
          </button>

          <div class="mt-6">
            <h3>JSON</h3>
            <pre><code v-html="json"></code></pre>

            <h3>HTML</h3>
            <pre><code>{{ html }}</code></pre>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import { Editor, EditorContent } from "tiptap";
import JetButton from "@/Jetstream/Button";
import Content from "../content";
import JetFormSection from "@/Jetstream/FormSection";
import EditMenuBar from "./EditMenuBar";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import UploadPhoto from "./PhotoUpload";

import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from "tiptap-extensions";
import FormSection from "../../Jetstream/FormSection.vue";

export default {
  components: {
    AppLayout,
    Welcome,
    EditorContent,
    JetButton,
    EditMenuBar,
    JetFormSection,
    JetInput,
    JetLabel,
    JetInputError,
    JetActionMessage,
    UploadPhoto,
  },

  props: {
    page: String,
  },

  data() {
    return {
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new BulletList(),
          new OrderedList(),
          new ListItem(),
          new TodoItem(),
          new TodoList(),
          new Bold(),
          new Code(),
          new Italic(),
          new Link(),
          new Strike(),
          new Underline(),
          new History(),
        ],

        // content: `
        //   <h1>Yay Headlines!</h1>
        //   <p>All these <strong>cool tags</strong> are working now.</p>
        // `,
        content: Content,
        onUpdate: ({ getJSON, getHTML }) => {
          this.json = getJSON();
          this.html = getHTML();
        },
      }),
      json: "Update content to see changes",
      html: Content,

      form: this.$inertia.form(
        {
          photo: null,
        },
        {
          bag: "saveImage",
        }
      ),

      photoPreview: null,
    };
  },
  beforeDestroy() {
    this.editor.destroy();
  },

  methods: {
    savePost: function () {
      const data = {};
      data["content"] = this.html;
      axios.post(route("save").url(), data).then((response) => {
        console.log(response.data);
      });
    },

    saveImage: () => {
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
