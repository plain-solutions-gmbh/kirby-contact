<template>
  <div v-if="item" class="contact-item">
    <k-grid variant="columns">
      <k-tag
        v-bind="item"
        :text="item.text"
        style="--width: 1/3"
        class="contact-toggle"
        @click.native="$refs[name]?.open()"
      />
      <div class="contact-label-wrapper" style="--width: 2/3">
        <k-input
          type="text"
          :value="value.value"
          :before="urlSplit(true)"
          :after="urlSplit()"
          :placeholder="url ? '' : $t('url')"
          :style="'--width:2/3'"
          @input="inputValue($event)"
        />

        <k-button
          v-if="disabled === false"
          icon="dots"
          variant="filled"
          @click="$refs.options.toggle()"
        />
      </div>

    </k-grid>

    <k-dropdown-content
      ref="options"
      :options="[
        {
          click: () => $emit('add', index + 1),
          icon: 'add',
          disabled: !more,
          text: $t('add'),
        },
        {
          click: () => $emit('remove', index),
          icon: 'trash',
          text: $t('delete'),
        },
        {
          click: () => {
            $emit('open', value);
          },
          icon: 'dots',
          when: Object.keys(fields).length > 0,
          text: $t('more'),
        },
      ]"
      align-x="end"
    />
    <k-dropdown-content
      v-if="filteredoptions.length > 0"
      :ref="name"
      align-x="start"
      :disabled="disabled"
      :navigate="false"
      class="k-picklist-dropdown"
      @click.native.stop
    >
      <contact-input
        v-bind="$props"
        :options="filteredoptions"
        :value="value.type"
        @click.native.stop
        @input="input({ type: $event })"
      />
    </k-dropdown-content>
    <k-form-drawer style="--width: 1/1" :fields="fields" />
  </div>
</template>

<script>
export default {
  props: {
    index: String,
    more: Boolean,
    fields: Object,
    disabled: Boolean,
    row: Object,
    options: Array,
    filteredoptions: Array,
  },
  data() {
    return {
      value: [],
    };
  },
  computed: {
    url() {
      return this.item?.url ?? "";
    },
    name() {
      return "smpick" + this.index;
    },
    item() {
      return this.options.find((item) => item.value === this.value.type);
    },
  },

  watch: {
    row: {
      handler(value) {
        if (value !== this.items) {
          this.value = value;
        }
      },
      immediate: true,
    },
  },
  methods: {
    inputValue(value) {
      value = this.$helper.string.ltrim(value, this.urlSplit(true));
      value = this.$helper.string.rtrim(value, this.urlSplit());
      this.input({ value: value });
    },
    input(value) {
      this.value = Object.assign({}, this.value, value);
      this.$emit("update", this.index, this.value);
    },
    urlSplit(before = false) {
      const split = this.url.split("{value}");
      return before ? split[0] : split[1] ?? "";
    },
  },
};
</script>

<style>
.contact-label-wrapper > .k-input {
  flex: 1 1 auto;
}
.contact-label-wrapper {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}
.contact-item > div.k-grid {
  grid-column-gap: var(--spacing-2);
  grid-row-gap: var(--spacing-1);
}
.contact-toggle {
  outline: 1px solid var(--input-color-border);
  justify-content: start;
  min-height: var(--input-height);
  box-shadow: var(--input-shadow);
  border-radius: var(--input-rounded);
  width: var(--button-width);
}
</style>
