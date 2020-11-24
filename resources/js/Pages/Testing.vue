<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <div class="flex justify-between p-4">
              <edit-menu-bar :editor="editor" />
          </div>
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
import Content from "./content";
import JetFormSection from '@/Jetstream/FormSection';
import EditMenuBar from './Edit/EditMenuBar';

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

export default {
  components: {
    AppLayout,
    Welcome,
    EditorContent,
    JetButton,
    EditMenuBar
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
    };
  },
  beforeDestroy() {
    this.editor.destroy();
  },

  methods: {
    savePost: function () {

      const data = {};
      data['content'] = this.html;
      axios.post(route("save").url(), data)
        .then((response) => {
          console.log(response.data);
      });
    },
  },
};
</script>
