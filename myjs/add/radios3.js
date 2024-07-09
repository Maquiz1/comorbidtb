// function checkRadioButtons2() {
//   const elementsToHide2 = {
//     sample_type2: ["sample_type_other2_1", "sample_type_other2_2"],
//   };

//   Object.keys(elementsToHide2).forEach((question) => {
//     const radios = document.getElementsByName(question);
//     let value = "";

//     radios.forEach((radio) => {
//       if (radio.checked) {
//         value = radio.value;
//       }

//       radio.addEventListener("change", () => {
//         elementsToHide2[question].forEach((elementId) => {
//           if (radio.value === "96" && radio.checked) {
//             document.getElementById(elementId).classList.remove("hidden");
//           } else {
//             document.getElementById(elementId).classList.add("hidden");
//           }
//         });
//       });
//     });

//     elementsToHide2[question].forEach((elementId) => {
//       if (value === "96") {
//         document.getElementById(elementId).classList.remove("hidden");
//       } else {
//         document.getElementById(elementId).classList.add("hidden");
//       }
//     });
//   });
// }

// window.onload = checkRadioButtons2;

