function checkRadioButtonsMany() {
  const elementsToControlMany = {
    qn71: {
      1: ["tb_outcome_date_cured", "tb_outcome_date"],
      2: ["tb_outcome_date_completed", "tb_outcome_date"],
      3: ["tb_outcome_date_death", "tb_outcome_date"],
      5: ["tb_outcome_date_last_seen", "tb_outcome_date"],
    },
    // phenotypic_method: {
    //   1: ["apm_date_1", "apm_date"],
    //   2: ["mgit_date2_1", "mgit_date2"],
    // },
    // question2: {
    //     '1': ['element4'],
    //     '2': ['element5']
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
