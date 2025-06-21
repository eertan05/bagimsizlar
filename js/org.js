
const selectElement = Array.from(document.getElementsByClassName("cbo_legalStatusID"));

var checkToRadio = function( event) {
    for (var i = 0; i < selectElement.length; i++) {
        selectElement[i].checked = false;
    }
    event.target.checked = true;
}
for (var i = 0; i < selectElement.length; i++) {
    selectElement[i].addEventListener('change',checkToRadio);
}