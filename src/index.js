import ContactField from "@/fields/Contact.vue";
import ContactItem from "@/components/ContactItem.vue";
import ContactInput from "@/components/ContactInput.vue";

window.panel.plugin("plain/contact", {
  fields: {
    contact: ContactField,
  },
  components: {
    "contact-item": ContactItem,
    "contact-input": ContactInput,
  },
  icons: {
    kirby:
      '<svg viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M21.5 6.5L12 1L2.5 6.5V17.5L12 23L21.5 17.5V6.5ZM19.6562 7.625L12 3.25L4.34375 7.625V16.375L12 20.75L19.6562 16.375V7.625Z"></path><path d="M16 12.35L13.5 13.85V14H16V16L7.99838 16.0032L7.99715 14H10.55V13.85L8.00386 12.35V9.8L12.0023 12.15L16 9.80246"></path></svg>',
  },
});
