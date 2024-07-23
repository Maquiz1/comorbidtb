function checkRadioButtonsMany() {
  const elementsToControlMany = {
    qn07: {
      1: ["qn07_date_1", "qn07_date"],
    },
    qn08: {
      1: ["qn09", "qn10", "qn11"],
    },
    qn10: {
      1: ["qn10_miaka", "qn10_miaka_1"],
    },
    qn17: {
      1: ["qn18", "qn20", "qn21", "qn22", "qn23", "qn24"],
    },
    qn18: {
      2: ["qn19"],
    },
    qn25: {
      1: ["qn25_idadi"],
    },
    qn26: {
      1: ["qn26_idadi"],
    },
    qn27: {
      1: ["qn27_idadi"],
    },
    qn28: {
      1: ["qn28_idadi"],
    },
    qn41: {
      1: ["qn42", "qn43", "qn44"],
    },
    qn45: {
      1: ["qn46", "qn47", "qn48"],
    },
    qn61: {
      1: ["qn61_date_1", "qn61_date"],
    },
    qn62: {
      1: ["qn62_i_1", "qn62_i"],
    },
    qn63: {
      1: ["qn63_date1", "qn63_date"],
    },
    qn64: {
      1: ["qn65"],
    },
    // qn65: {
    //   96: ["qn65_other1", "qn65_other"],
    // },
    // qn71: {
    //   1: ["tb_outcome_date_cured", "tb_outcome_date"],
    //   2: ["tb_outcome_date_completed", "tb_outcome_date"],
    //   3: ["tb_outcome_date_death", "tb_outcome_date"],
    //   5: ["tb_outcome_date_last_seen", "tb_outcome_date"],
    // },

    // tb_dawa: {
    //   1: ["tb_dawa_tarehe1", "tb_dawa_tarehe"],
    //   2: ["mgit_date2_1", "mgit_date2"],
    // },
    // qn66: {
    //   1: ["qn67"],
    // },
    // qn68: {
    //   1: ["qn69"],
    // },
    // question3: {
    //     '1': [],
    //     '0': []
    // }
  };

  function handleVisibilityMany() {
    // Hide all controlled elements
    Object.values(elementsToControlMany)
      .flatMap((condition) => Object.values(condition).flat())
      .forEach((elementId) => {
        document.getElementById(elementId).classList.add("hidden");
      });

    // Iterate through all questions
    Object.keys(elementsToControlMany).forEach((question) => {
      const radios = document.getElementsByName(question);
      let selectedValue = null;

      // Find the checked radio button
      radios.forEach((radio) => {
        if (radio.checked) {
          selectedValue = radio.value;
        }

        // Add event listener for changes
        radio.addEventListener("change", () => {
          handleVisibilityMany();
        });
      });

      // Show elements based on the selected value
      if (selectedValue && elementsToControlMany[question][selectedValue]) {
        elementsToControlMany[question][selectedValue].forEach((elementId) => {
          document.getElementById(elementId).classList.remove("hidden");
        });
      }
    });
  }

  // Initial visibility check on page load
  window.onload = handleVisibilityMany;
}

checkRadioButtonsMany();
