function checkRadioButtons96() {
  const elementsToHide96 = {
    sample_type: ["sample_type_other1", "sample_type_other"],
  };

  Object.keys(elementsToHide96).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHide96[question].forEach((elementId) => {
          if (radio.value === "96" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHide96[question].forEach((elementId) => {
      if (value === "96") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });
}

window.onload = checkRadioButtons96;

