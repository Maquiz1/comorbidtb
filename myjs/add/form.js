// document.addEventListener("DOMContentLoaded", function () {
//   var form = document.getElementById("validation");
//   var checkboxes = form.querySelectorAll(
//     'input[type="checkbox"][name^="qn65"]'
//   );
//   var submitButton = form.querySelector('button[type="submit"]');

//   // Function to validate at least one specific checkbox is checked
//   function validateSpecificCheckbox() {
//     var checked = false;
//     checkboxes.forEach(function (checkbox) {
//       if (checkbox.checked) {
//         checked = true;
//       }
//     });

//     if (checked) {
//       submitButton.disabled = false;
//     } else {
//       submitButton.disabled = true;
//     }
//   }

//   // Add event listener to each specific checkbox for validation
//   checkboxes.forEach(function (checkbox) {
//     checkbox.addEventListener("change", validateSpecificCheckbox);
//   });
// });
