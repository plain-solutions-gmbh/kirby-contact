<template>
  <div>
    <k-navigate
      v-if="true /*['add', 'edit'].includes(mode)*/"
      element="nav"
      axis="y"
      :autofocus="true"
      select="input[type=search], label, .k-picklist-input-body button"
      class="k-picklist-input"
      @prev="$emit('mode', null)"
    >
      <header v-if="value === '_custom'" class="k-picklist-input-header">
        <div class="k-picklist-input-search">
          <k-search-input
            :value="value.label"
            :placeholder="$t('plain.contact.custom.label.label')"
            @input="input({ label: $event })"
          />
        </div>
      </header>

      <header v-if="search" class="k-picklist-input-header">
        <div class="k-picklist-input-search">
          <k-search-input
            ref="search"
            :autofocus="autofocus"
            :disabled="disabled"
            :placeholder="placeholder"
            :value="query"
            @input="query = $event"
            @keydown.escape.native.prevent="escape"
            @keydown.enter.native.prevent="add"
          />
        </div>
      </header>

      <div class="k-picklist-input-body">
        <ul
          :style="{ '--columns': 1 }"
          class="k-radio-input k-grid"
          data-variant="choices"
        >
          <li
            v-for="(choice, index) in choices"
            :key="index"
            @click="$emit('input', choice.value)"
          >
            <k-tag class="contact-button" v-bind="choice" />
          </li>
        </ul>

        <k-button
          v-if="display !== true && filteredOptions.length > display"
          class="k-picklist-input-more"
          icon="angle-down"
          @click="display = true"
        >
          {{ $t("options.all", { count: filteredOptions.length }) }}
        </k-button>
      </div>
    </k-navigate>
  </div>
</template>

<script>
export default {
  extends: "k-picklist-input",
  inheritAttrs: false,
};
</script>

<style>
.contact-button-group {
  justify-content: center;
  border-bottom: 1px solid var(--dropdown-color-hr);
}

.contact-button-group > span {
  position: absolute;
  transform: translateX(15px);
}

.contact-button {
  width: 100%;
  justify-content: start;
}

.contact-button .k-tag-text {
  flex: 1 1 100%;
  text-align: left;
}
</style>
