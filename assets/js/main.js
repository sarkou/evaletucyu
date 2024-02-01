function afficherRadio() {
  const radios = document.querySelectorAll(".radio_hidden_libre");
  radios.forEach(function (radio) {
    radio.style.visibility = "visible";
  });
}
function afficherRadioM() {
  const radios = document.querySelectorAll(".radio_hidden_mineure");
  radios.forEach(function (radio) {
    radio.style.visibility = "visible";
  });
}
