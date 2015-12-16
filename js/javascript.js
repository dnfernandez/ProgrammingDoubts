var cont=0;
var cont2=0;

function show_form1() {
	document.getElementById("formPregunta").style.display="block";
	document.getElementById("cuerpoP").style.visibility="hidden";
	document.getElementById("formRegistro").style.display="none";
	document.getElementById("formModificarD").style.display="none";
	document.getElementById("formPreguntaM").style.display="none";
	document.getElementById("formRespuestaR").style.display="none";

}
function show_form2() {
	document.getElementById("formRegistro").style.display="block";
	document.getElementById("cuerpoP").style.visibility="hidden";
	if(document.getElementById("formPregunta")){
		document.getElementById("formPregunta").style.display="none";
	}
	if(document.getElementById("formRespuesta")){
		document.getElementById("formRespuesta").style.display="none";
	}
	if(document.getElementById("formRespuestaR")) {
		document.getElementById("formRespuestaR").style.display = "none";
	}
	document.getElementById("formPreguntaM").style.display="none";
}

function show_form3() {
	document.getElementById("formModificarD").style.display="block";
	document.getElementById("cuerpoP").style.visibility="hidden";
	if(document.getElementById("formPregunta")){
		document.getElementById("formPregunta").style.display="none";
	}
	if(document.getElementById("formRespuesta")){
		document.getElementById("formRespuesta").style.display="none";
	}
	if(document.getElementById("formRespuestaR")) {
		document.getElementById("formRespuestaR").style.display = "none";
	}
	document.getElementById("formPreguntaM").style.display="none";
}

function show_form4() {
	document.getElementById("formRespuesta").style.display="block";
	document.getElementById("cuerpoP").style.visibility="hidden";
	document.getElementById("formRegistro").style.display="none";
	document.getElementById("formModificarD").style.display="none";
	document.getElementById("formPreguntaM").style.display="none";
	document.getElementById("formRespuestaR").style.display = "none";

}

function show_form5(codPre) {
	document.getElementById("formPreguntaM").style.display="block";
	document.getElementById("formPreguntaMF").innerHTML = "<input type='hidden' name='codPre' value='"+codPre+"' >";
	document.getElementById("cuerpoP").style.visibility="hidden";
	document.getElementById("formRegistro").style.display="none";
	document.getElementById("formModificarD").style.display="none";
	document.getElementById("formPregunta").style.display="none";
	document.getElementById("formRespuestaR").style.display="none";

}

function show_form6(codRes) {
	document.getElementById("formRespuestaR").style.display="block";
	document.getElementById("formComR").innerHTML = "<input type='hidden' name='codRes' value='"+codRes+"' >";
	document.getElementById("cuerpoP").style.visibility="hidden";
	document.getElementById("formRespuesta").style.display="none";
	document.getElementById("formRegistro").style.display="none";
	document.getElementById("formModificarD").style.display="none";
	document.getElementById("formPreguntaM").style.display="none";
}

function hide_form1() {
	document.getElementById("formPregunta").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";
}

function hide_form2() {
	document.getElementById("formRegistro").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";

}

function hide_form3() {
	document.getElementById("formModificarD").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";
}

function hide_form4() {
	document.getElementById("formRespuesta").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";
	document.getElementById("formRespuestaR").style.display = "none";
}

function hide_form5() {
	document.getElementById("formPreguntaM").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";
}

function hide_form6() {
	document.getElementById("formRespuestaR").style.display="none";
	document.getElementById("cuerpoP").style.visibility="visible";
}

function validateDatos(trad, trad1, trad2){
	var password = document.getElementById("register-password").value;
	var pass2 = document.getElementById("register-repeatPassword").value

	if(password.length == 0 || pass2.length == 0){
		$.notify(trad2, "error");
	}
	if(validateName(trad) && validateName2(trad1) && validatePassword(trad2)) {
		document.forms["registerform"].submit();
	}
}

function validateDatos2(trad, trad1){

	var password = document.getElementById("register-passwordM").value;
	var pass2 = document.getElementById("register-repeatPasswordM").value

	if(password.length == 0 || pass2.length == 0){
		$.notify(trad1, "error");
	}
	if(validateNameModif2(trad) && validatePasswordModif(trad1)) {
		document.forms["modifform"].submit();
	}
}

function validateName(traduccion) {
	var name = document.getElementById("register-name").value;

	//Comprobaciones de "nombre", no se puede registrar nadie sin nombre.
	if (name.length == 0) {
		$("#div-name").removeClass("has-success");
		$("#div-name").addClass("has-error");
		$.notify(traduccion, "error");

		return false;
	}
	else {
		$("#div-name").removeClass("has-error");
		$("#div-name").addClass("has-success");

		return true;
	}
}

function validateName2(traduccion) {
	var name = document.getElementById("register-name2").value;

	//Comprobaciones de "nombre", no se puede registrar nadie sin nombre.
	if (name.length == 0) {
		$("#div-name2").removeClass("has-success");
		$("#div-name2").addClass("has-error");
		$.notify(traduccion, "error");

		return false;
	}
	else {
		$("#div-name2").removeClass("has-error");
		$("#div-name2").addClass("has-success");

		return true;
	}
}

function validatePassword(traduccion) {
	//var cont = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,15})$/;
	var cont = /(?=.*\d)(?=.*[a-z]){6,15}/;
	var password = document.getElementById("register-password").value;
	var pass2 = document.getElementById("register-repeatPassword").value

	if(password.length == 0 || pass2.length == 0) return false;

	if ((cont.test(password) == 0) || (password.length < 6) || (password.length > 15) || (password != pass2)) {

		$("#div-password").removeClass("has-success");
		$("#div-password").addClass("has-error");
		$("#div-repeatPassword").removeClass("has-success");
		$("#div-repeatPassword").addClass("has-error");
		$.notify(traduccion,"error");
		return false;
	}
	else {
		$("#div-password").removeClass("has-error");
		$("#div-password").addClass("has-success");
		$("#div-repeatPassword").removeClass("has-error");
		$("#div-repeatPassword").addClass("has-success");


		return true;
	}
}

function validateNameModif2(traduccion) {
	var name = document.getElementById("modif-name2").value;

	//Comprobaciones de "nombre", no se puede registrar nadie sin nombre.
	if (name.length == 0) {
		$("#div-name2M").removeClass("has-success");
		$("#div-name2M").addClass("has-error");
		$.notify(traduccion, "error");

		return false;
	}
	else {
		$("#div-name2M").removeClass("has-error");
		$("#div-name2M").addClass("has-success");

		return true;
	}
}

function validatePasswordModif(traduccion) {
	//var cont = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,15})$/;
	var cont = /(?=.*\d)(?=.*[a-z]){6,15}/;
	var password = document.getElementById("register-passwordM").value;
	var pass2 = document.getElementById("register-repeatPasswordM").value

	if(password.length == 0 || pass2.length == 0) return false;

	if ((cont.test(password) == 0) || (password.length < 6) || (password.length > 15) || (password != pass2)) {

		$("#div-passwordM").removeClass("has-success");
		$("#div-passwordM").addClass("has-error");
		$("#div-repeatPasswordM").removeClass("has-success");
		$("#div-repeatPasswordM").addClass("has-error");
		$.notify(traduccion);
		return false;
	}
	else {
		$("#div-passwordM").removeClass("has-error");
		$("#div-passwordM").addClass("has-success");
		$("#div-repeatPasswordM").removeClass("has-error");
		$("#div-repeatPasswordM").addClass("has-success");


		return true;
	}
}

function validateDatosPM(trad,trad1,traduccion){
	validateEtiqM();

	if(cont2<1){
		$.notify(traduccion);
	}

	if(validateTitM(trad) && validateTextM(trad1) && cont2>=1) {
		document.forms["formPregM"].submit();
	}else{
		cont2=0;
	}
}

function validateDatosP(trad1,traduccion){
	validateEtiq();

	if(cont<1){
		$.notify(traduccion);
	}

	if(validateTit(trad1) && validateText(trad1) && cont>=1) {
		document.forms["formPreg"].submit();
	}else{
		cont=0;
	}
}

function  validateTit(traduccion){
	valor = document.getElementById("comTit").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-tit").removeClass("has-success");
		$("#div-tit").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-tit").removeClass("has-error");
		$("#div-tit").addClass("has-success");

		return true;
	}
}


function  validateTitM(traduccion){
	valor = document.getElementById("comTitM").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-titM").removeClass("has-success");
		$("#div-titM").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-titM").removeClass("has-error");
		$("#div-titM").addClass("has-success");

		return true;
	}
}

function  validateText(traduccion){
	valor = document.getElementById("comText").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-text").removeClass("has-success");
		$("#div-text").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-text").removeClass("has-error");
		$("#div-text").addClass("has-success");

		return true;
	}
}

function  validateTextM(traduccion){
	valor = document.getElementById("comTextM").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-textM").removeClass("has-success");
		$("#div-textM").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-textM").removeClass("has-error");
		$("#div-textM").addClass("has-success");

		return true;
	}
}

function validateEtiq(){
	for(var i=0; i<document.formPreg.elements.length;i++){
		if (document.formPreg.elements[i].type == 'checkbox') {
			if (document.formPreg.elements[i].checked == true) {
				cont++;
			}
		}
	}

}

function validateEtiqM(){
	for(var i=0; i<document.formPregM.elements.length;i++){
		if (document.formPregM.elements[i].type == 'checkbox') {
			if (document.formPregM.elements[i].checked == true) {
				cont2++;
			}
		}
	}

}

function validateDatosR(trad){
	if(validateText2(trad) ) {
		document.forms["formRes"].submit();
	}
}

function validateDatosRR(trad){
	if(validateText2R(trad) ) {
		document.forms["formResR"].submit();
	}
}

function  validateText2(traduccion){
	valor = document.getElementById("comText2").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-text2").removeClass("has-success");
		$("#div-text2").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-text2").removeClass("has-error");
		$("#div-text2").addClass("has-success");

		return true;
	}
}

function  validateText2R(traduccion){
	valor = document.getElementById("comText2R").value;
	if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
		$("#div-text2R").removeClass("has-success");
		$("#div-text2R").addClass("has-error");
		$.notify(traduccion, "error");
		return false;
	}
	else {
		$("#div-text2R").removeClass("has-error");
		$("#div-text2R").addClass("has-success");

		return true;
	}
}