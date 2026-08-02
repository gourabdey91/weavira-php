(function () {

  const { ModuleContainer, GroupContainer, FieldContainer } = window.divi.module;
  const { Select } = window.divi.fieldLibrary;
  const { registerModule } = window.divi.moduleLibrary;
  const { addAction } = window.vendor.wp.hooks;

  const metadata = {
    name: "smsalert/divi-selector",
    title: "SMSAlert",
    category: "module",
    attributes: {
      formId: {
        type: "string",
        default: ""
      }
    }
  };

  /* SETTINGS */

  const Settings = (props) => {

    return React.createElement(
      GroupContainer,
      { ...props, id: "formSettings", title: "Form Settings" },

      React.createElement(
        FieldContainer,
        { ...props, attrName: "formId", label: "Select Form" },

        React.createElement(Select, {
          options: {
            "1": { label: "Signup With Mobile" },
            "2": { label: "Login With OTP" },
            "3": { label: "Share Cart Button" }
          },
          emptyLabel: "Select Form"
        })
      )
    );

  };

  /* PREVIEW */

  const Edit = (props) => {

    const formId = props?.attrs?.formId?.desktop?.value || "";

    if (formId) {

      const data = new URLSearchParams();
      data.append("action", "smsalert_divi_preview");
      data.append("form_id", formId);
      data.append("nonce", smsalert_divi_builder.nonce);

      fetch(smsalert_divi_builder.ajax_url, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: data
      })
      .then(res => res.json())
      .then(resp => {

        const container = document.querySelector(".et_pb_module_inner");

        if (container && resp.success) {
          container.innerHTML = resp.data;
        }

      });

    }

    return React.createElement(
      ModuleContainer,
      props,
      React.createElement(
        "div",
        {
          className: "et_pb_module_inner"
        },
        "Loading preview..."
      )
    );

  };

  const moduleDefinition = {
    metadata,
    renderers: {
      edit: Edit
    },
    settings: {
      content: Settings
    }
  };

  addAction(
    "divi.moduleLibrary.registerModuleLibraryStore.after",
    "smsalert",
    function () {
      registerModule(metadata, moduleDefinition);
    }
  );

})();