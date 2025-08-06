(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$2 = {
    props: {
      options: Object,
      value: Array,
      label: String,
      max: Number,
      sortable: Boolean,
      empty: String,
      prepend: Boolean,
      disabled: Boolean,
      fields: Object
    },
    created() {
      console.log(this.options);
    },
    data() {
      return {
        items: this.value
      };
    },
    computed: {
      choice() {
        return this.options.map((option) => {
          var _a;
          return {
            html: true,
            image: { icon: option.icon, color: option.color },
            disabled: this.disabled || option.disabled,
            text: option.label,
            value: option.type,
            url: ((_a = option == null ? void 0 : option.output) == null ? void 0 : _a.contact) ?? null
          };
        });
      },
      drawerFields() {
        return Object.keys(this.fields).filter((key) => !["type", "value"].includes(key)).reduce((obj, key) => {
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
      }
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
        index ?? (index = this.prepend ? 0 : this.items.length);
        this.items.splice(index, 0, {
          type: this.filteredChoice[0].value
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
                fields: this.drawerFields
              }
            },
            title: this.label,
            value: item
          },
          replace,
          on: {
            input: (value) => {
              const i = this.findIndex(value);
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
            }
          }
        });
      }
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-field", _vm._b({ staticClass: "k-contact-field" }, "k-field", _vm.$props, false), [_c("k-draggable", { attrs: { "list": _vm.items, "handle": ".contact-toggle", "options": {
      disabled: _vm.sortable === false,
      //Cause conflict with the dropdown
      delay: 500
    } }, on: { "sort": _vm.save } }, _vm._l(_vm.items, function(item, index) {
      return _c("contact-item", _vm._b({ key: index, attrs: { "row": item, "fields": _vm.drawerFields, "onsort": _vm.onsort, "index": index, "more": _vm.more, "filteredoptions": _vm.filteredChoice, "options": _vm.choice }, on: { "remove": _vm.remove, "update": _vm.update, "add": _vm.add, "open": _vm.open } }, "contact-item", _vm.$props, false));
    }), 1), _vm.items.length === 0 ? _c("k-empty", { attrs: { "data-invalid": _vm.isInvalid, "text": _vm.empty, "icon": "list-bullet" }, on: { "click": function($event) {
      return _vm.add();
    } } }) : _vm._e(), _vm.more ? _c("footer", { staticClass: "contact-footer" }, [_c("k-button", { attrs: { "title": _vm.$t("add"), "icon": "add", "size": "xs", "variant": "filled" }, on: { "click": function($event) {
      return _vm.add();
    } } })], 1) : _vm._e()], 1);
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2
  );
  __component__$2.options.__file = "/Users/romangsponer/Cloud/_sites/marketplace/site/plugins/kirby-contact/src/fields/Contact.vue";
  const ContactField = __component__$2.exports;
  const _sfc_main$1 = {
    props: {
      index: String,
      more: Boolean,
      fields: Object,
      disabled: Boolean,
      row: Object,
      options: Array,
      filteredoptions: Array
    },
    data() {
      return {
        value: []
      };
    },
    computed: {
      url() {
        var _a;
        return ((_a = this.item) == null ? void 0 : _a.url) ?? "";
      },
      name() {
        return "smpick" + this.index;
      },
      item() {
        return this.options.find((item) => item.value === this.value.type);
      }
    },
    watch: {
      row: {
        handler(value) {
          if (value !== this.items) {
            this.value = value;
          }
        },
        immediate: true
      }
    },
    methods: {
      inputValue(value) {
        value = this.$helper.string.ltrim(value, this.urlSplit(true));
        value = this.$helper.string.rtrim(value, this.urlSplit());
        this.input({ value });
      },
      input(value) {
        this.value = Object.assign({}, this.value, value);
        this.$emit("update", this.index, this.value);
      },
      urlSplit(before = false) {
        const split = this.url.split("{value}");
        return before ? split[0] : split[1] ?? "";
      }
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _vm.item ? _c("div", { staticClass: "contact-item" }, [_c("k-grid", { attrs: { "variant": "columns" } }, [_c("k-tag", _vm._b({ staticClass: "contact-toggle", staticStyle: { "--width": "1/3" }, attrs: { "text": _vm.item.text }, nativeOn: { "click": function($event) {
      var _a;
      (_a = _vm.$refs[_vm.name]) == null ? void 0 : _a.open();
    } } }, "k-tag", _vm.item, false)), _c("div", { staticClass: "contact-label-wrapper", staticStyle: { "--width": "2/3" } }, [_c("k-input", { style: "--width:2/3", attrs: { "type": "text", "value": _vm.value.value, "before": _vm.urlSplit(true), "after": _vm.urlSplit(), "placeholder": _vm.url ? "" : _vm.$t("url") }, on: { "input": function($event) {
      return _vm.inputValue($event);
    } } }), _vm.disabled === false ? _c("k-button", { attrs: { "icon": "dots", "variant": "filled" }, on: { "click": function($event) {
      return _vm.$refs.options.toggle();
    } } }) : _vm._e()], 1)], 1), _c("k-dropdown-content", { ref: "options", attrs: { "options": [
      {
        click: () => _vm.$emit("add", _vm.index + 1),
        icon: "add",
        disabled: !_vm.more,
        text: _vm.$t("add")
      },
      {
        click: () => _vm.$emit("remove", _vm.index),
        icon: "trash",
        text: _vm.$t("delete")
      },
      {
        click: () => {
          _vm.$emit("open", _vm.value);
        },
        icon: "dots",
        when: Object.keys(_vm.fields).length > 0,
        text: _vm.$t("more")
      }
    ], "align-x": "end" } }), _vm.filteredoptions.length > 0 ? _c("k-dropdown-content", { ref: _vm.name, staticClass: "k-picklist-dropdown", attrs: { "align-x": "start", "disabled": _vm.disabled, "navigate": false }, nativeOn: { "click": function($event) {
      $event.stopPropagation();
    } } }, [_c("contact-input", _vm._b({ attrs: { "options": _vm.filteredoptions, "value": _vm.value.type }, on: { "input": function($event) {
      return _vm.input({ type: $event });
    } }, nativeOn: { "click": function($event) {
      $event.stopPropagation();
    } } }, "contact-input", _vm.$props, false))], 1) : _vm._e(), _c("k-form-drawer", { staticStyle: { "--width": "1/1" }, attrs: { "fields": _vm.fields } })], 1) : _vm._e();
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1
  );
  __component__$1.options.__file = "/Users/romangsponer/Cloud/_sites/marketplace/site/plugins/kirby-contact/src/components/ContactItem.vue";
  const ContactItem = __component__$1.exports;
  const _sfc_main = {
    extends: "k-picklist-input",
    inheritAttrs: false
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_c("k-navigate", { staticClass: "k-picklist-input", attrs: { "element": "nav", "axis": "y", "autofocus": true, "select": "input[type=search], label, .k-picklist-input-body button" }, on: { "prev": function($event) {
      return _vm.$emit("mode", null);
    } } }, [_vm.value === "_custom" ? _c("header", { staticClass: "k-picklist-input-header" }, [_c("div", { staticClass: "k-picklist-input-search" }, [_c("k-search-input", { attrs: { "value": _vm.value.label, "placeholder": _vm.$t("plain.contact.custom.label.label") }, on: { "input": function($event) {
      return _vm.input({ label: $event });
    } } })], 1)]) : _vm._e(), _vm.search ? _c("header", { staticClass: "k-picklist-input-header" }, [_c("div", { staticClass: "k-picklist-input-search" }, [_c("k-search-input", { ref: "search", attrs: { "autofocus": _vm.autofocus, "disabled": _vm.disabled, "placeholder": _vm.placeholder, "value": _vm.query }, on: { "input": function($event) {
      _vm.query = $event;
    } }, nativeOn: { "keydown": [function($event) {
      if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "escape", void 0, $event.key, void 0)) return null;
      $event.preventDefault();
      return _vm.escape.apply(null, arguments);
    }, function($event) {
      if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
      $event.preventDefault();
      return _vm.add.apply(null, arguments);
    }] } })], 1)]) : _vm._e(), _c("div", { staticClass: "k-picklist-input-body" }, [_c("ul", { staticClass: "k-radio-input k-grid", style: { "--columns": 1 }, attrs: { "data-variant": "choices" } }, _vm._l(_vm.choices, function(choice, index) {
      return _c("li", { key: index, on: { "click": function($event) {
        return _vm.$emit("input", choice.value);
      } } }, [_c("k-tag", _vm._b({ staticClass: "contact-button" }, "k-tag", choice, false))], 1);
    }), 0), _vm.display !== true && _vm.filteredOptions.length > _vm.display ? _c("k-button", { staticClass: "k-picklist-input-more", attrs: { "icon": "angle-down" }, on: { "click": function($event) {
      _vm.display = true;
    } } }, [_vm._v(" " + _vm._s(_vm.$t("options.all", { count: _vm.filteredOptions.length })) + " ")]) : _vm._e()], 1)])], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns
  );
  __component__.options.__file = "/Users/romangsponer/Cloud/_sites/marketplace/site/plugins/kirby-contact/src/components/ContactInput.vue";
  const ContactInput = __component__.exports;
  window.panel.plugin("plain/contact", {
    fields: {
      contact: ContactField
    },
    components: {
      "contact-item": ContactItem,
      "contact-input": ContactInput
    },
    icons: {
      kirby: '<svg viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M21.5 6.5L12 1L2.5 6.5V17.5L12 23L21.5 17.5V6.5ZM19.6562 7.625L12 3.25L4.34375 7.625V16.375L12 20.75L19.6562 16.375V7.625Z"></path><path d="M16 12.35L13.5 13.85V14H16V16L7.99838 16.0032L7.99715 14H10.55V13.85L8.00386 12.35V9.8L12.0023 12.15L16 9.80246"></path></svg>'
    }
  });
})();
