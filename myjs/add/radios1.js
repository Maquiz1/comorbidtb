// // const test = document.getElementById("tb_dawa_tarehe1");
// // console.log(test);

// function TbComorbidityRadios() {
//   const elementsToHideTbComorbidity = {
//     tb_dawa: ["tb_dawa_tarehe1", "tb_dawa_tarehe"],
//     qn08: ["qn09", "qn10"],
//     // chest_x_ray: ["chest_x_ray_date1", "chest_x_ray_date"],
//     // sample_received: [
//     //   // "test_rejected",
//     //   "sample_received_hides1",
//     //   "sample_received_hides2",
//     // ],
//     // culture_done: ["sample_type2", "sample_methods"],
//     // phenotypic_done: ["phenotypic_method", "phenotypic_done00"],
//     // genotyping_done: ["genotyping_asay", "genotyping_done00"],
//     // nanopore_sequencing_done: [
//     //   "nanopore_sequencing",
//     //   "nanopore_sequencing_done00",
//     // ],
//     // tb_diagnosis: [
//     //   "tb_diagnosis_made",
//     //   "bacteriological_diagnosis",
//     //   "tb_diagnosis_hides",
//     // ],
//   };

//   Object.keys(elementsToHideTbComorbidity).forEach((question) => {
//     const radios = document.getElementsByName(question);
//     let value = "";

//     radios.forEach((radio) => {
//       if (radio.checked) {
//         value = radio.value;
//       }

//       radio.addEventListener("change", () => {
//         elementsToHideTbComorbidity[question].forEach((elementId) => {
//           if (radio.value === "1" && radio.checked) {
//             document.getElementById(elementId).classList.remove("hidden");
//           } else {
//             document.getElementById(elementId).classList.add("hidden");
//           }
//         });
//       });
//     });

//     elementsToHideTbComorbidity[question].forEach((elementId) => {
//       if (value === "1") {
//         document.getElementById(elementId).classList.remove("hidden");
//       } else {
//         document.getElementById(elementId).classList.add("hidden");
//       }
//     });
//   });
// }

// window.onload = TbComorbidityRadios;
