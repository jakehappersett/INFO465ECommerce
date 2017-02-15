
function ValidateForm() {
  //alert('Boo');
  if (! document.bunform.RunJS.checked) {
    return true;
  }
  //return true;
  var ValidationErrors = '';
  var CrLf = "\r\n\r\n";
  if (document.bunform.Firstname.value == '') {
    ValidationErrors += 'First Name is a required field.  Please supply your name...' + CrLf; 
  }
  if (document.bunform.Lastname.value == '') {
    ValidationErrors += 'Last Name is a required field.  Please supply your name...' + CrLf; 
  }
  if (document.bunform.Address.value == '') {
    ValidationErrors += 'Address is a required field.  Please supply your name...' + CrLf; 
  }
  if (document.bunform.City.value == '') {
    ValidationErrors += 'City is a required field.  Please supply your name...' + CrLf; 
  }
 // if (document.bunform.state.value == '') {
 //   validationerrors += 'state is a required field.  please supply your name...' + crlf; 
 // }
  if (document.bunform.Zip.value == '') {
    ValidationErrors += 'Zip is a required field.  Please supply your name...' + CrLf; 
  }
  if (document.bunform.MAEmail.value == '') {
    ValidationErrors += 'EmailAddress is a required field.  Please supply your email address...' + CrLf;
  }
  if (document.bunform.MAOpinion.value == '') {
    ValidationErrors += 'Please enter some values!' + CrLf;
  }
  if ((document.bunform.MAPass1.value == '') || (document.bunform.MAPass2.value == '')) {
    ValidationErrors += 'Please enter your password, twice.' + CrLf;
  } else if (document.bunform.MAPass1.value != document.bunform.MAPass2.value) {
    ValidationErrors += 'Passwords entered are not the same.' + CrLf;
  }
  if (ValidationErrors == '') {
    return true;
  } else {
    alert(ValidationErrors);
    return false;
  }
}


