

























// function checkCheckboxes1() {
//   const elementsToControl11 = {
//     nanopore_sequencing: {
//       2: ["nanopore_sequencing_done00"],
//     },
//     // question2: {
//     //   1: ["element4"],
//     //   2: ["element5"],
//     // },
//     // question3: {
//     //   1: ["element1", "element4"],
//     //   0: ["element2", "element5"],
//     // },
//   };

//   function handleVisibility11() {
//     // Hide all controlled elements
//     Object.values(elementsToControl11)
//       .flatMap((condition) => Object.values(condition).flat())
//       .forEach((elementId) => {
//         document.getElementById(elementId).classList.add("hidden");
//       });

//     // Iterate through all questions
//     Object.keys(elementsToControl11).forEach((question) => {
//       const checkboxes = document.getElementsByName(question);

//       // Show elements based on the selected checkboxes
//       checkboxes.forEach((checkbox) => {
//         if (checkbox.checked) {
//           const value = checkbox.value;
//           if (elementsToControl11[question][value]) {
//             elementsToControl11[question][value].forEach((elementId) => {
//               document.getElementById(elementId).classList.remove("hidden");
//             });
//           }
//         }

//         // Add event listener for changes
//         checkbox.addEventListener("change", () => {
//           handleVisibility11();
//         });
//       });
//     });
//   }

//   // Initial visibility check on page load
//   window.onload = handleVisibility11;
// }

// checkCheckboxes1();
















// // // checkCheckboxes1();

// // // function checkCheckboxes1() {
// // //   const elementsToControl = {
// // //     nanopore_sequencing: ["nanopore_sequencing_done00"],
// // //     option2: ["element2"],
// // //     option3: ["element3"],
// // //   };

// // //   function handleVisibility() {
// // //     // Hide all controlled elements
// // //     Object.values(elementsToControl)
// // //       .flat()
// // //       .forEach((elementId) => {
// // //         document.getElementById(elementId).classList.add("hidden");
// // //       });

// // //     // Show elements based on the selected checkboxes
// // //     Object.keys(elementsToControl).forEach((option) => {
// // //       const checkbox = document.querySelector(`input[name="${option}"]`);

// // //       if (checkbox.checked) {
// // //         elementsToControl[option].forEach((elementId) => {
// // //           document.getElementById(elementId).classList.remove("hidden");
// // //         });
// // //       }

// // //       // Add event listener for changes
// // //       checkbox.addEventListener("change", () => {
// // //         handleVisibility();
// // //       });
// // //     });
// // //   }

// // //   // Initial visibility check on page load
// // //   window.onload = handleVisibility;
// // // }

// // // checkCheckboxes1();
