// function RadiosBaselineOther() {
//   const elementsToHideBaselineOther = {
//     qn14: ["qn14_other", "qn14_other1"],
//   };

//   Object.keys(elementsToHideBaselineOther).forEach((question) => {
//     const radios = document.getElementsByName(question);
//     let value = "";

//     radios.forEach((radio) => {
//       if (radio.checked) {
//         value = radio.value;
//       }

//       radio.addEventListener("change", () => {
//         elementsToHideBaselineOther[question].forEach((elementId) => {
//           if (radio.value === "96" && radio.checked) {
//             document.getElementById(elementId).classList.remove("hidden");
//           } else {
//             document.getElementById(elementId).classList.add("hidden");
//           }
//         });
//       });
//     });

//     elementsToHideBaselineOther[question].forEach((elementId) => {
//       if (value === "96") {
//         document.getElementById(elementId).classList.remove("hidden");
//       } else {
//         document.getElementById(elementId).classList.add("hidden");
//       }
//     });
//   });
// }

// window.onload = RadiosBaselineOther;
