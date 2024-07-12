function RadiosBaseline() {
  const elementsToHideBaseline = {
    // tb_dawa: ["tb_dawa_tarehe1", "tb_dawa_tarehe"],
    // qn08: ["qn09", "qn10"],
    qn08: ["qn09"],
    qn10: ["qn10_miaka_1"],
    qn12: ["qn13"],
    qn13: ["qn14"],
    qn25: ["qn25_idadi"],
    qn26: ["qn26_idadi"],
    qn27: ["qn27_idadi"],
    qn28: ["qn28_idadi"],
    qn64: ["qn65"],
  };

  const elementsToHideBaselineOther = {
    qn14: ["qn14_other", "qn14_other1"],
  };

  const elementsToHideBaselineHapana = {
    qn18: ["qn19"],
  };

  const elementsToHideBaseline1_2 = {
    qn25: ["qn26"],
  };

  Object.keys(elementsToHideBaseline).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHideBaseline[question].forEach((elementId) => {
          if (radio.value === "1" && radio.checked) {
              document.getElementById(elementId).classList.remove("hidden");
            //   qn10_miaka.setAttribute("required", "required");
          } else {
              document.getElementById(elementId).classList.add("hidden");
            //   qn10_miaka.removeAttribute("required");
          }
        });
      });
    });

    elementsToHideBaseline[question].forEach((elementId) => {
      if (value === "1") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });

  // HIDES HAPANA
  Object.keys(elementsToHideBaselineHapana).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHideBaselineHapana[question].forEach((elementId) => {
          if (radio.value === "2" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHideBaselineHapana[question].forEach((elementId) => {
      if (value === "2") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });

  // HIDE IF OTHER
  Object.keys(elementsToHideBaselineOther).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHideBaselineOther[question].forEach((elementId) => {
          if (radio.value === "96" && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHideBaselineOther[question].forEach((elementId) => {
      if (value === "96") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });

  // SHOW IF 1 Or 2
  Object.keys(elementsToHideBaseline1_2).forEach((question) => {
    const radios = document.getElementsByName(question);
    let value = "";

    radios.forEach((radio) => {
      if (radio.checked) {
        value = radio.value;
      }

      radio.addEventListener("change", () => {
        elementsToHideBaseline1_2[question].forEach((elementId) => {
          if ((radio.value === "1" || radio.value === "2") && radio.checked) {
            document.getElementById(elementId).classList.remove("hidden");
          } else {
            document.getElementById(elementId).classList.add("hidden");
          }
        });
      });
    });

    elementsToHideBaseline1_2[question].forEach((elementId) => {
      if (value === "1" || value === "2") {
        document.getElementById(elementId).classList.remove("hidden");
      } else {
        document.getElementById(elementId).classList.add("hidden");
      }
    });
  });
}

window.onload = RadiosBaseline;
