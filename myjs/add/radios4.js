// function checkRadioButtons4() {
//   const elementsToControl = {
//     phenotypic_method: {
//       1: ["apm_date", "apm_date_1"],
//       2: ["mgit_date2", "mgit_date2_1"],
//     },
//   };

//   function handleVisibility4() {
//     // Hide all controlled elements
//     Object.values(elementsToControl)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         document.getElementById(elementId).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControl).forEach((question) => {
//       const radios = document.getElementsByName(question);
//       let selectedValue = null;

//       // Find the checked radio button
//       radios.forEach((radio) => {
//         if (radio.checked) {
//           selectedValue = radio.value;
//         }

//         // Add event listener for changes
//         radio.addEventListener("change", () => {
//           handleVisibility4();
//         });
//       });

//       // Show elements based on the selected value
//       if (selectedValue && elementsToControl[question][selectedValue]) {
//         elementsToControl[question][selectedValue].forEach((elementId) => {
//           document.getElementById(elementId).classList.remove("hidden");
//         });
//       }
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibility4;
// }

// checkRadioButtons4();
