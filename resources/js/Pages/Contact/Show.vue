<template>
  <div>
    <app-layout>
      <template #header>
      </template>
      <div>
        <div class="w-full">
            <img :src="publicImagePath" class="h-50 w-full object-scale-down"/>
        </div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <contact-form :user="$page.user" :email="email" :phone="phone" />

            <jet-section-border />

        </div>
      </div>
    </app-layout>
  </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Input from "@/Jetstream/Input";
import FormSection from "@/Jetstream/FormSection";
import Button from "@/Jetstream/Button";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetSectionBorder from "@/Jetstream/SectionBorder";
import ContactForm from './ContactForm';

export default {
  components: {
    AppLayout,
    Input,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSectionBorder,
    ContactForm,
  },

  props: {
      image_path: String,
      email: String,
      phone: String
  },

  data(){
    return {
        publicImagePath: `/storage/${this.image_path}`
    }
  }


};
</script>
