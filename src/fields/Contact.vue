<template>
  <k-field class="k-contact-field" v-bind="$props">
    <k-draggable
      :list="items"
      handle=".contact-toggle"
      :options="{
        disabled: sortable === false,
        //Cause conflict with the dropdown
        delay: 500,
      }"
      @sort="save"
    >
      <contact-item
        v-for="(item, index) in items"
        v-bind="$props"
        :key="index"
        :row="item"
        :fields="drawerFields"
        :onsort="onsort"
        :index="index"
        :more="more"
        :filteredoptions="filteredChoice"
        :options="choice"
        @remove="remove"
        @update="update"
        @add="add"
        @open="open"
      />
    </k-draggable>
    <k-empty
      v-if="items.length === 0"
      :data-invalid="isInvalid"
      :text="empty"
      icon="list-bullet"
      @click="add()"
    />

    <footer v-if="more" class="contact-footer">
      <k-button
        :title="$t('add')"
        icon="add"
        size="xs"
        variant="filled"
        @click="add()"
      />
    </footer>
  </k-field>
</template>

<script>
export default {
  props: {
    options: Object,
    value: Array,
    label: String,
    max: Number,
    sortable: Boolean,
    empty: String,
    prepend: Boolean,
    disabled: Boolean,
    fields: Object,
  },
  created() {
    console.log(this.options)
  },
  data() {
    return {
      items: this.value,
    };
  },
  computed: {
    choice() {
      return this.options.map((option) => {
        return {
          html: true,
          image: { icon: option.icon, color: option.color },
          disabled: this.disabled || option.disabled,
          text: option.label,
          value: option.type,
          url: option?.output?.contact ?? null,
        };
      });
    },
    drawerFields() {
      return Object.keys(this.fields)
      .filter(key => !['type', 'value'].includes(key))
      .reduce((obj, key) => {
        obj[key] = this.fields[key];
        return obj;
      }, {});
    },
    filteredChoice() {
      const filter = this.value.map((item) => item.type);
      return this.choice.filter((option) => !filter.includes(option.value));
    },
    more() {
      if (this.max && this.items.length > this.max) {
        return false;
      }
      return this.filteredChoice.length > 0;
    },
  },
  methods: {
    save() {
      this.$emit("input", this.items);
    },
    update(i, value) {
      this.items[i] = value;
      this.save();
    },
    remove(i) {
      this.items.splice(i, 1);
      this.save();
    },
    add(index) {
      index ??= this.prepend ? 0 : this.items.length;
      this.items.splice(index, 0, {
        type: this.filteredChoice[0].value,
      });
      this.save();
    },
    navigate(item, step) {
      const index = this.findIndex(item);

      if (this.disabled === true || index === -1) {
        return;
      }

      this.open(this.items[index + step], true);
    },
    findIndex(item) {
      return this.items.findIndex((val) => val._id === item._id);
    },
    open(item, replace = false) {
      const index = this.findIndex(item);

      if (this.disabled === true || index === -1) {
        return false;
      }

      this.$panel.drawer.open({
        component: "k-structure-drawer",
        id: this.id,
        props: {
          icon: this.icon ?? "list-bullet",
          next: this.items[index + 1],
          prev: this.items[index - 1],
          tabs: {
            content: {
              fields: this.drawerFields,
            },
          },
          title: this.label,
          value: item,
        },
        replace: replace,
        on: {
          input: (value) => {
            const i = this.findIndex(value);

            // update the prev/next navigation
            this.$panel.drawer.props.next = this.items[i + 1];
            this.$panel.drawer.props.prev = this.items[i - 1];

            this.update(i, value);
          },
          next: () => {
            this.navigate(item, 1);
          },
          prev: () => {
            this.navigate(item, -1);
          },
          remove: () => {
            this.remove(item);
          },
        },
      });
    },
  },
};
</script>

<style>
.contact-item {
  padding-bottom: var(--spacing-1);
}
.contact-footer {
  display: flex;
  justify-content: center;
  padding-top: var(--spacing-2);
}
</style>
