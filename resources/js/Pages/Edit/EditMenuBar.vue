<template>
    <div class="flex justify-between p-4">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button :class="{ 'is-active': isActive.bold() }" @click="commands.bold">
        <strong>B</strong>
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.strike() }"
        @click="commands.strike"
      >
        <del>S</del>
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.italic() }"
        @click="commands.italic"
      >
        <i>I</i>
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.heading({ level: 1 }) }"
        @click="commands.heading({ level: 1 })"
      >
        H1
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.heading({ level: 2 }) }"
        @click="commands.heading({ level: 2 })"
      >
        H2
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.heading({ level: 3 }) }"
        @click="commands.heading({ level: 3 })"
      >
        H3
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button :class="{ 'is-active': isActive.code() }" @click="commands.code">
        <>
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button
        :class="{ 'is-active': isActive.underline() }"
        @click="commands.underline"
      >
        <u>U</u>
      </button>
    </editor-menu-bar>
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <button :class="{ 'is-active': isActive.link() }" @click="commands.link">
        <u>Link</u>
      </button>
    </editor-menu-bar>
  </div>
</template>

<script>
    import { EditorMenuBar } from "tiptap";

    export default {
        components: {
            EditorMenuBar,
        },

        props: [ 'editor']

    }

</script>
